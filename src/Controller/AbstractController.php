<?php
namespace APP\Controller;

use Slim\Views\Twig as TwigViews;

/**
 * Class AbstractController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="localhost:8000",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0.0",
 *         title="Sample Application",
 *         @SWG\Contact(name="Drew D. Lenhart", url="https://drewlenhart.com"),
 *     )
 * )
 */

class AbstractController
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}
