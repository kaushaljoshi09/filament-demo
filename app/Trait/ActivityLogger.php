<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

trait ActivityLogger
{
    /**
     * Log activity for a given model and action
     * @param array $logData
     *
     * @return void
     */
    public static function log(array $logData)
    {
        // Default log data setup
        $data = self::getLogParams($logData);

        // Create the activity instance and start logging
        activity()
            ->performedOn($data['model'])
            ->event($data['event'])
            ->useLog($data['log_name'])
            ->causedBy($data['causedBy'])
            ->withProperties([
                'user_agent' => request()->userAgent(),
                'user_ip' => request()->ip(),
                'changed_record' => $data['model']->getChanges(),  // Gets the updated values
            ])
            ->log($data['description']);
    }

    protected static function getReference($data)
    {
        if(isset($data['full_name'])) {
            return $data['full_name'];
        } elseif(isset($data['name'])) {
            return $data['name'];
        } elseif(isset($data['title'])) {
            return $data['title'];
        } elseif(isset($data['id'])) {
            return 'ID: ' . $data['id'];
        }
    }

    public static function getLogParams(array $logData) {
        // Default log data setup
        $data = $logData;

        // Determine the causer (either authenticated user or performedOn object)
        $causedBy = auth()->check() ? auth()->user() : $data['model'];

        $properties = $data['model'] ? $data['model']->only($data['model']->getFillable()) : [];

        // For custom events, modify the description
        if (in_array($data['event'], ['created', 'updated', 'deleted'])) {
            $data['description'] = sprintf(
                "The '%s' named '%s' has been '%s' by '%s' successfully.",
                strtolower($data['log_name']),
                self::getReference($properties)  ?? 'Unknown Item',
                strtolower($data['event']),
                $causedBy->full_name ?? $causedBy->name,
            );
        } else {
            $data['description'] = sprintf(
                "%s has been '%s' successfully.",
                $causedBy->full_name ?? $causedBy->name,
                strtolower($data['event']),
            );
        }

        $data['causedBy'] = $causedBy;
        $data['causer_type'] = $causedBy;
        $data['causer_id'] = $causedBy ? $causedBy->getKey() : null;
        $data['properties'] = $properties;

        return $data;
    }

    /**
     * Log BATCH activity for a given model and action
     * @param array $logData
     *
     * @return void
     */
    public static function logBatchActivities(array $logsData)
    {
        // Prepare an array to hold the batch data
        $batchData = [];

        // Loop through each log entry
        foreach ($logsData as $logData) {

            $data = self::getLogParams($logData);

            // Prepare the activity data
            $batchData[] = [
                'log_name' => $data['log_name'],
                'event' => $data['event'],
                'description' => $data['description'],
                'subject_type' => $data['subject'] ? get_class($data['subject']) : null,
                'subject_id' => $data['subject'] ? $data['subject']->getKey() : null,
                'causer_type' => $data['causer_type'],
                'causer_id' => $data['causer_id'],
                'properties' => $data['properties']
            ];
        }

        // Log activities in a batch
        Activity::logBatch($batchData);
    }

    /**
     * Get activities for a specific subject
     *
     * @param Model $subject // Model with the relationship with auth user
     * @param array $filters Additional filters
     * @return Collection
     */

     public static function getSubjectActivities(Model $subject, Model $relationModel = null, array $filters = []): Collection
     {
        $logObject = Activity::where('causer_type', get_class($subject));

        // Nested query for 'subject_type' and 'subject_id'
        if ($relationModel) {
            $logObject =  $logObject->when(function($query) use ($relationModel) {
                $query->where('subject_type', get_class($relationModel))
                        ->where('subject_id', $relationModel->getKey());
            });
        }
        if (!empty($filters)) {
            // Filter by 'log_name' if provided
            $logObject = $logObject->when(!empty($filters['log_name']), function ($query) use ($filters) {
                return $query->where('log_name', $filters['log_name']);
            })
            // Filter by 'event' if provided
            ->when(!empty($filters['event']), function ($query) use ($filters) {
                return $query->where('event', $filters['event']);
            });
        }


       return $logObject->get();
     }

}
