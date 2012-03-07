<?php

require_once 'phar://'.__DIR__.'/silex.phar/autoload.php';
require_once __DIR__ . '/src/House.php';
require_once __DIR__ . '/src/Mongo.php';

use Findahouse\document\House;
use Findahouse\mongo\Mongo;

$app = new Silex\Application();

$app->post('/house/create', function() use($app) {

        $house = new House();

        $house->setAddress($app['request']->get('formatted_address'));
        $house->setAddressComponents($app['request']->get('address_components'));
        $house->setLatLng($app['request']->get('latLng'));
        $house->setContact($app['request']->get('contact'));
        $house->setDescription($app['request']->get('description'));
        $house->setDistanceTownship($app['request']->get('distanceTownship'));
        $house->setName($app['request']->get('name'));
        $house->setNbBatiments($app['request']->get('batiments'));
        $house->setNote($app['request']->get('note'));
        $house->setPhotos($app['request']->get('photos'));
        $house->setPrice($app['request']->get('price'));
        $house->setSurfaceHabitable($app['request']->get('surfaceHabitable'));
        $house->setSurfaceTerrain($app['request']->get('surfaceTerrain'));
        $house->setUrlAnnonce($app['request']->get('urlAnnonce'));

        $house->save();
        
        return 1;
    });
$app->get('/house/all', function() use($app) {

        $cursor = Mongo::getConnection()->selectDB('findahouse')
            ->selectCollection('house')
            ->find();
        
        $houses = array();
        foreach ($cursor as $data) {
            
            if ($data != null) {
                
            $data['id'] = $data['_id']->{'$id'};
            unset($data['_id']);
                $houses[] = $data;
            }
        }
        
        return json_encode($houses);
    });

$app->get('/house/{id}', function($id) use($app) {

        $data = Mongo::getConnection()->selectDB('findahouse')
            ->selectCollection('house')
            ->findOne(array('_id' => new \MongoId($id)));

        $house = null;
        if ($data != null) {
            
            $house = $data;
            $house['id'] = $house['_id']->{'$id'};
            unset($house['_id']);
        }
        
        return json_encode($house);
    });
$app->post('/house/{id}', function($id) use($app) {

        $data = Mongo::getConnection()->selectDB('findahouse')
            ->selectCollection('house')
            ->findOne(array('_id' => new \MongoId($id)));

        $house = null;
        if ($data != null) {
            
            $house = new House();
            $house ->hydrate($data);
        }
        
        $house->setContact($app['request']->get('contact'));
        $house->setDescription($app['request']->get('description'));
        $house->setDistanceTownship($app['request']->get('distanceTownship'));
        $house->setName($app['request']->get('name'));
        $house->setNbBatiments($app['request']->get('batiments'));
        $house->setNote($app['request']->get('note'));
        $house->setPhotos($app['request']->get('photos'));
        $house->setPrice($app['request']->get('price'));
        $house->setSurfaceHabitable($app['request']->get('surfaceHabitable'));
        $house->setSurfaceTerrain($app['request']->get('surfaceTerrain'));
        $house->setUrlAnnonce($app['request']->get('urlAnnonce'));
        
        $house->save();
        
        return json_encode($house);
    });
$app->get('/user/auth', function() use($app) {
    
        
        
        return 1;
    });
$app->run();
