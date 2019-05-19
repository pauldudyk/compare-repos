<?php

namespace Modules\Comparator\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comparator\Helpers\RepositoryService;
use Modules\Comparator\Helpers\Services\Github;
use Modules\Comparator\Transformers\RepoResource;
use Modules\Comparator\Http\Requests\FindRequest;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Compare repos",
 *      description="Compare two repos",
 *      @OA\Contact(
 *          email="dudekpavlo@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="L5 Swagger OpenApi Server"
 * ) 
 * 
 * )
 *  
 * 
 */

class ComparatorController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/comparator/find",
     *     tags={"comparator"},
     *     summary="Get info about repos",
     *     operationId="find",
     * @OA\Parameter(
     *         name="firstPackage",
     *         in="query",
     *         description="First package",
     *          required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     * @OA\Parameter(
     *         name="secondPackage",
     *         in="query",
     *         description="Second package",
     *          required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="Repos data",
     *         @OA\JsonContent(
     *             type="object",
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="data", type="string", example="Repo data"),
     *         ),
     *     ),
     * )
     */
    public function find(FindRequest $request)
    {
        $finder = new RepositoryService(new Github());

        $firstPackage = $finder->find($request->firstPackage);
        $secondPackage = $finder->find($request->secondPackage);
        
        $reposResource = RepoResource::collection(collect([$firstPackage, $secondPackage]));
        
        return $reposResource;
    }

}
