<?php
namespace APP\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Schema;
use APP\Models\Sample;

/**
 * Class CreateSampleController
 * @package CreateSampleController\Controller
 */

class CreateSampleController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    // Create SAMPLE SQLITE database
    // Please remove from production code.
    public function createDatabaseSample(Request $request, Response $response, $args)
    {
        //Create a sample database for examples.
        $baseDir = __DIR__ . '/../../data/sample.sqlite';
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

    // Create Admin User - SAMPLE CODE - REMOVE
    public function createUserTable(Request $request, Response $response, $args)
    {
        // This is just an example.  This uses the SAMPLE SQLite db & creates User table.
        // Edit model User to use another database....

        // check if Users table exsists
        $table = "Users";
        $check = DB::connection('sqlite')->getSchemaBuilder()->hasTable($table);

        if (!$check) {
            echo "NO table found, creating table";

            $create = DB::connection('sqlite')->select("CREATE TABLE Users (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				name VARCHAR(255),
				email VARCHAR(255) NOT NULL,
				password VARCHAR(255) NOT NULL,
				created_at TIMESTAMP,
				updated_at TIMESTAMP
			)");
        } else {
            echo "table exsists";
        }
    }
}
