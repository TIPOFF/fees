<?php

declare(strict_types=1);

namespace Tipoff\Fees\Nova;

use \Tipoff\Fees\Models\LocationFee as LocationFeeModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class LocationFee extends BaseResource
{
    public static $model = LocationFeeModel::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $group = 'Operations Units';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location')) : null,
            nova('fee') ? BelongsTo::make('Booking Fee', 'bookingFee', nova('fee')) : null,
            nova('fee') ? BelongsTo::make('Product Fee', 'productFee', nova('fee')) : null,
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->rules('required')->creationRules('unique:location_fees,location_id')->updateRules('unique:location_fees,location_id,{{resourceId}}') : null,
            nova('fee') ? BelongsTo::make('Booking Fee', 'bookingFee', nova('fee')) : null,
            nova('fee') ? BelongsTo::make('Product Fee', 'productFee', nova('fee')) : null,
            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
        );
    }
}
