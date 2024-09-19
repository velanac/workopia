<?php

namespace App\Controllers;

use Framework\Database;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        loadView('listings/index', ['listings' => $listings]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? null;

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        // Check if listing exsist
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', ['listing' => $listing]);
    }

    /**
     * Match a value against another
     * @param string $value1
     * @param string $value2
     * @return bool
     */
    public static function match($value1, $value2)
    {
        $value1 = trim($value1);
        $value2 = trim($value2);

        return $value1 === $value2;
    }
}
