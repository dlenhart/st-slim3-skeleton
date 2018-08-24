<?php
namespace APP\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Schema;
use APP\Models\Sample;

/**
 * Class HomeController
 * @package HomeController\Controller
 */

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    // Home Page
    public function index(Request $request, Response $response, $args)
    {
        $data = array('title' => 'Home');
        return $this->view->render($response, 'Home.html', $data);
    }

    // Create SAMPLE SQLITE database
    public function createDatabaseSample(Request $request, Response $response, $args)
    {
        //Create a sample database for examples.
        $baseDir = __DIR__ . '\..\..\data\sample.sqlite';
        // Check if the sample db exsists.
        if (file_exists($baseDir)) {
            echo "Database Exsists!<br />";
            echo "Creating table with sample data......<br /><br />";
            //check for sample table
            if (DB::connection('sqlite')->getSchemaBuilder()->hasTable('Sample')) {
                echo 'Table already exsists!<br /><br />';
                // Echo out whats in table
                $output = new Sample;
                $output = Sample::all();
                echo $output . "<br /><br />";
                echo "<a href='/'><< Home</a>";
            } else {
                echo 'Creating table.....';
                $create = DB::connection('sqlite')->select("CREATE TABLE Sample (
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
        					name CHAR(100) NOT NULL,
        					email CHAR(50) NOT NULL
        				)");
                // Insert a dummy record using Model
                $insert = new Sample;
                $insert->name = 'Test User 1';
                $insert->email = 'testuseremail1@email.com';
                $insert->save();
                if ($insert) {
                    echo "<br />demo data saved!<br /><br />";
                    // Echo out whats in table
                    $output = new Sample;
                    $output = Sample::all();
                    echo $output . "<br /><br />";
                    echo "<a href='/'><< Home</a>";
                }
            }
        } else {
            // Create new file
            $fh = fopen($baseDir, 'w') or die('Unable to create database!');
            if ($fh) {
                echo "Database successfully created!<br />";
                echo "<a href='/createSample'>Create Data!</a>";
            }
            fclose($fh);
        }
    }
}
