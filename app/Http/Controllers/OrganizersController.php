<?php

namespace App\Http\Controllers;

use App\Models\Organizers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Organizers as OrganizerCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class OrganizersController extends Controller
{

    /**
     * List All Organizers with Users
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        try {

            $query = Organizers::organizers()
                ->with('user');

            return OrganizerCollection::collection($query->paginate(10));

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a new Organizer in the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $event_id = $request->get('event_id', null);
        $name = $request->get('name', '');
        $email = $request->get('email', '');
        $password = $request->get('password', '');

        try {
            DB::beginTransaction();

            $model = new Organizers;

            $user = $model->createOrganizerUser(
                $name,
                $email,
                $password
            );

            $model->createOrganizer($user->id, $event_id);
            $model->setRelation('user', $model->user);

            DB::commit();

            return response()->json([
                'message' => __('common.saved'),
                'organizer' => $model
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Retrieve an Organizer
     *
     * @param $organizer_id
     * @return JsonResponse
     */
    public function retrieve($organizer_id)
    {
        try {
            $model = Organizers::findOrFail($organizer_id);
            $model->setRelation('user', $model->user);

            return response()->json([
                'message' => __('common.found'),
                'model' => $model
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update an Organizer data
     *
     * @param Request $request
     * @param $organizer_id
     * @return JsonResponse
     */
    public function update(Request $request, $organizer_id)
    {
        try {
            DB::beginTransaction();

            $model = Organizers::findOrFail($organizer_id);

            $name = $request->get('name', $model->name);
            $email = $request->get('email', $model->email);
            $password = $request->get('password', $model->password);

            $model->updateOrganizerUser($name, $email, $password);
            $model->setRelation('user', $model->user);

            DB::commit();

            return response()->json([
                'message' => __('common.updated'),
                'organizer' => $model
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete an Organizer from the database
     *
     * @param $organizer_id
     * @return JsonResponse
     */
    public function delete($organizer_id)
    {
        try {
            DB::beginTransaction();

            $organizer = Organizers::findOrFail($organizer_id);
            $organizer->user()->delete();
            $organizer->delete();

            DB::commit();

            return response()->json([
                'message' => __('common.deleted')
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
