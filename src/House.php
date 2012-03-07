<?php

namespace Findahouse\document;

require_once 'Mongo.php'; 

use Findahouse\mongo\Mongo;

/**
 * Description of House
 *
 * @author antoineguiral
 */
class House {
    //put your code here
    private $id;
    
    private $name;
    
    private $latLng;
    private $address;
    private $addressComponents=array();
    
    private $surfaceHabitable;
    private $surfaceTerrain;
    private $price;
    private $nbBatiments;
    private $distanceTownship;
    private $description;
    
    private $photos=array();
    
    
    private $urlAnnonce;
    
    private $contact;
    
    private $note;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLatLng() {
        return $this->latLng;
    }

    public function setLatLng($latLng) {
        $this->latLng = $latLng;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAddressComponents() {
        return $this->addressComponents;
    }

    public function setAddressComponents($addressComponents) {
        $this->addressComponents = $addressComponents;
    }

    public function getSurfaceHabitable() {
        return $this->surfaceHabitable;
    }

    public function setSurfaceHabitable($surfaceHabitable) {
        $this->surfaceHabitable = $surfaceHabitable;
    }

    public function getSurfaceTerrain() {
        return $this->surfaceTerrain;
    }

    public function setSurfaceTerrain($surfaceTerrain) {
        $this->surfaceTerrain = $surfaceTerrain;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    
    public function getDistanceTownship() {
        return $this->distanceTownship;
    }

    public function setDistanceTownship($distanceTownship) {
        $this->distanceTownship = $distanceTownship;
    }

    public function getNbBatiments() {
        return $this->nbBatiments;
    }

    public function setNbBatiments($nbBatiments) {
        $this->nbBatiments = $nbBatiments;
    }

    public function getPhotos() {
        return $this->photos;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }

    public function getUrlAnnonce() {
        return $this->urlAnnonce;
    }

    public function setUrlAnnonce($urlAnnonce) {
        $this->urlAnnonce = $urlAnnonce;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    
    public function save(){
        $thisToArray=get_object_vars($this);
        
        $mongo=  Mongo::getConnection();
        $db = $mongo->selectDB('findahouse');
        $collectionHouse = $db->selectCollection('house');
         if($this->id==null){
             
            unset($thisToArray['id']);
            $a=$collectionHouse->save($thisToArray, array("safe" => true));
            $this->id=$thisToArray['_id']->{'$id'};
        }else{
            $thisToArray['_id']=new \MongoId($thisToArray['id']);
            unset($thisToArray['id']);
            $collectionHouse->save($thisToArray);
        }
        
        
    }
    
    public function hydrate($data) {
        $this->id=$data['_id']->{'$id'};
        $this->name=$data['name'];
        $this->latLng=$data['latLng'];
        $this->address=$data['address'];
        $this->addressComponents =$data['addressComponents'];
        $this->surfaceHabitable=$data['surfaceHabitable'];
        $this->surfaceTerrain=$data['surfaceTerrain'];
        $this->price=$data['price'];
        $this->distanceTownship=$data['distanceTownship'];
        $this->nbBatiments=$data['nbBatiments'];
        $this->photos =$data['photos'];
        $this->urlAnnonce=$data['urlAnnonce'];
        $this->contact=$data['contact'];
        $this->note=$data['note'];
        $this->description=$data['description'];
    }
    public function toArray($data) {
        return get_object_vars($this);
    }
}

