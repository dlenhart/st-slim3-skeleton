<?php
namespace APP\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use APP\Models\Sample;

/**
 * Class ApiController - EXAMPLE!
 * @package ApiController\Controller
 */

class ApiController extends AbstractController {
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    public function example(Request $request, Response $response, $args) {

      /**
       * Display a listing of the resource.
       *
       * @return Response
       *
       * @SWG\Get(
       *     path="/api/sample",
       *     description="Returns entries in table.",
       *     produces={"application/json"},
       *     tags={"Sample"},
       *     @SWG\Response(
       *         response=200,
       *         description="OK"
       *     ),
       *     @SWG\Response(
       *         response=401,
       *         description="Unauthorized action.",
       *     )
       * )
       */

        $sample = new Sample;
        $sample = Sample::all();
        $response->write($sample);
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
     
    public function examplePost(Request $request, Response $response, $args) {
        /**
       * Some description here
       * @SWG\Post(
       *     path="/api/samplePost",
       *     description="Sample Post",
       *     operationId="",
       *     produces={"application/json"},
       *     tags={"Sample"},
       *      @SWG\Parameter(
       *          name="body",
       *          in="body",
       *          default="{}",
       *          description="blah blah blah",
       *          required=true,
       *          @SWG\Schema(
       *             @SWG\Property(property="foo", type="string", example="1234"),
       *             @SWG\Property(property="bar", type="string", example="5678")
       *             )
       *      ),
       *
       *     @SWG\Response(
       *         response=200,
       *         description="OK"
       *     ),
       *     @SWG\Response(
       *         response=422,
       *         description="Unprocessable Entity"
       *     )
       * )
       */

       // validate nothings empty
  		$validation = $this->validator->validate($request, [
  			'foo' => v::notEmpty(),
  			'bar' => v::notEmpty()
        ]);

        if ($validation->failed()){
    			// failed validation from APP\Validator
    			$getErrors = $validation->messages();
    			//rebuilding this - loop through msgs and build json
    			foreach($getErrors as $key=>$msg){
    				foreach($msg as $errr){
    					//messages
    					$errorMsg[] = array(
    						$key => $errr
    					);
    				}
    			}
    			$errors = json_encode($errorMsg, true);

    			$data = '{"Status": "Failed", "Message": ' . $errors . '}';

    			//return json msg
    			$response->write($data);
    			$response = $response->withHeader('Content-Type', 'application/json');
    			return $response;
    		}else{
    			$allVars = (array)$request->getParsedBody();
          $foo = $allVars['foo'];
			    $bar = $allVars['bar'];

          $status = '{"Status": "Success",
            "Message": "Passed Validation - ' . $foo . ' ' . $bar . '"}';

          //return json content type
          $response->write($status);
          $response = $response->withHeader('Content-Type', 'application/json');
          return $response;
        }
    }
}
