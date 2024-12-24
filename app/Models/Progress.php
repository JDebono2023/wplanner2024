<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for weight in metric
    public function getCurrentWeightInMetricAttribute()
    {
        return $this->unit_current === 'imperial' ? $this->current_weight * 0.453592 : $this->current_weight;
    }

    // Accessor for weight in imperial
    public function getCurrentWeightInImperialAttribute()
    {
        return $this->unit_current === 'metric' ? $this->current_weight / 0.453592 : $this->current_weight;
    }

    // Accessor for goal weight in metric
    public function getGoalWeightInMetricAttribute()
    {
        return $this->unit_goal === 'imperial' ? $this->goal_weight * 0.453592 : $this->goal_weight;
    }

    // Accessor for goal weight in imperial
    public function getGoalWeightInImperialAttribute()
    {
        return $this->unit_goal === 'metric' ? $this->goal_weight / 0.453592 : $this->goal_weight;
    }

    // Convert height to meters if needed
    public function getHeightInMetricAttribute()
    {
        return $this->unit_height === 'imperial' ? $this->height * 0.0254 : $this->height;
    }

    // Convert height to meters if needed
    public function getHeightInImperialAttribute()
    {
        return $this->unit_height === 'metric' ? $this->height / 0.0254 : $this->height;
    }

    // Calculate BMI in metric
    public function calculateBmi(): float
    {
        // Use current_weight for calculation
        $weightInKg = ($this->unit_current === 'metric')
            ? $this->current_weight
            : $this->current_weight * 0.453592; // Convert from lbs to kg if imperial

        $heightInMeters = ($this->unit_height === 'metric')
            ? $this->height
            : $this->height * 0.0254; // Convert from inches to meters if imperial

        // Calculate BMI using the formula
        return $heightInMeters > 0 ? round($weightInKg / ($heightInMeters * $heightInMeters), 2) : 0;
    }

    // Automatically calculate BMI before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->bmi = $model->calculateBmi();
        });
    }
}
