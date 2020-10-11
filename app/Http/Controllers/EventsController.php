<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \App\Http\Resources\Events as EventsCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    /**
     * List all Events with its Organizers
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        try {

            $query = Events::with('organizers.user');

            return EventsCollection::collection($query->paginate(10));

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a new Event in the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $model = new Events;

            $model->fill([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            $model->save();
            $model->setRelation('organizers', $model->organizers);

            DB::commit();

            return response()->json([
                'message' => __('common.saved'),
                'event' => $model
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Retrieve an Event
     *
     * @param $event_id
     * @return JsonResponse
     */
    public function retrieve($event_id)
    {
        try {

            $model = Events::find($event_id);
            if(!$model) {
                throw new \Exception(__('common.not_found'));
            }
            $model->setRelation('organizers', $model->organizers);

            return response()->json([
                'message' => __('common.found'),
                'event' => $model
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update an Event data
     *
     * @param Request $request
     * @param $event_id
     * @return JsonResponse
     */
    public function update(Request $request, $event_id)
    {
        try {
            DB::beginTransaction();

            $model = Events::findOrFail($event_id);

            $title = $request->get('title');
            $description = $request->get('description');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $model->update([
                'title' => $title,
                'description' => $description,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]);

            $model->setRelation('organizers', $model->organizers);

            DB::commit();

            return response()->json([
                'message' => __('common.saved'),
                'event' => $model
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete an Event from the database
     *
     * @param $event_id
     * @return JsonResponse
     */
    public function delete($event_id)
    {
        try {
            $model = Events::findOrFail($event_id);
            $model->delete();

            return response()->json([
                'message' => __('common.deleted')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
