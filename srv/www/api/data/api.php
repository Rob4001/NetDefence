<?php
header('Access-Control-Allow-Origin: http://geeksoc-hackathon.tk');
// database api connector

include("config.php");
include("class.pdo.php");
include("functions.inc.php");


//echo "Creating Data API";

class DataAPI {
	
	private $database;
	
	public function __construct() {
		try {
			$this->database = new PDODB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}
		catch(Exception $e) {
			die("Database Error: " . $e->getMessage());
		}
		
		//$this->get2Points();
		$lat = 55.8738672;
		$lon = -4.2920083;
		
		$this->nodesOnAxis($lat, $lon);
	}
	
	
		
	
	
	public function nodesOnAxis($lat, $lon) {
		$this->database->query("SELECT aps.ID, aps.LATITUDE, aps.LONGITUDE, aps.BSSID, aps.SECURITY, aps.OWNER, user.username, 

 
			(6378.10 * ACOS(COS(RADIANS(:lat)) 
                * COS(RADIANS(LATITUDE)) 
                * COS(RADIANS(:lon) - RADIANS(LONGITUDE)) 
                + SIN(RADIANS(:lat)) 
                * SIN(RADIANS(LATITUDE)))) * 1000 AS dist_m
			FROM aps

			LEFT JOIN `user` ON aps.OWNER = user.id


			
			WHERE LATITUDE >= :llat
			AND LATITUDE <= :mlat

			AND LONGITUDE >= :llong
			AND LONGITUDE <= :mlong
			
			GROUP BY LATITUDE, LONGITUDE
			ORDER BY LATITUDE


			
		");

		$this->database->bind(":lat", $lat);
		$this->database->bind(":lon", $lon);
		
		$this->database->bind(":llat", $lat - 0.0005);
		$this->database->bind(":mlat", $lat + 0.0005);
		
		$this->database->bind(":llong", $lon - 0.0005);
		$this->database->bind(":mlong", $lon + 0.0005);
		
		$this->database->execute();
		
		//echo "<h1> +/- 0.0005 latitude/longitude of {$lat}, {$lon}</h1><h4>NUMBER OF RESULTS {$this->database->rowCount()}</<br />";
		$data = $this->database->fetchResultSet();
		
		return $data;
		
		/*echo "<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>LATITUDE</th>
					<th>LONGITUDE</th>
					<th>DISTANCE FROM US (meters)</th>
				</tr>
			</thead>
			<tbody>";
			
		foreach($data as $item) {
			echo "<tr>
				<td>{$item['ID']}</td>
				<td>{$item['LATITUDE']}</td>
				<td>{$item['LONGITUDE']}</td>
				<td>{$item['dist_m']}</td>
			</tr>";
		}
		echo "</tbody>
		</table>";
		*/
		
	}
	
	
	
	
	
	
	
	
	
	
	public function get2Points() {
		$this->database->query("SELECT COUNT(*) FROM `aps`");
		$this->database->execute();
		$numRecords = $this->database->fetchResult();
		$numRecords = $numRecords['COUNT(*)'];
		
		$rnd1 = mt_rand(0, $numRecords);
		$rnd2 = mt_rand(0, $numRecords);
		
		
		$this->database->query("SELECT * FROM `aps` LIMIT 1 OFFSET " . $rnd1);
		$this->database->execute();
		$rand1 = $this->database->fetchResult();
		
		$this->database->query("SELECT * FROM `aps` LIMIT 1 OFFSET " . $rnd2);
		$this->database->execute();
		$rand2 = $this->database->fetchResult();
		
		
		echo distance($rand1['LATITUDE'], $rand1['LONGITUDE'], $rand2['LATITUDE'], $rand2['LONGITUDE'], "K") . "km";

	}


	// get access points (user id)
	public function getAccessPoints($userID) {
		$this->database->query("SELECT * FROM `aps` WHERE OWNER = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->execute();
		return $this->database->fetchResultSet();
	}

	public function getAccessPointCount($userID) {
		$this->database->query("SELECT COUNT(*) AS count FROM `aps` WHERE `OWNER` = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->execute();
		$result = $this->database->fetchResult();
		return $result['count'];
	}
	
	public function getNumUsers() {
		$this->database->query("SELECT COUNT(*) AS count FROM `user` WHERE `id` > 2");
		$this->database->execute();
		$result = $this->database->fetchResult();
		return $result['count'];
	}

	// get user resources (user id)
	public function getUserResources($userID) {
		$this->database->query("SELECT resources FROM `user` WHERE id  = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->execute();
		$resources = $this->database->fetchResult();
		return $resources['resources'];
	}

	// helper
	public function getResourceLimit($userID) {
		$this->database->query("SELECT maxres FROM `user` WHERE id  = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->execute();
		$resources = $this->database->fetchResult();
		return $resources['maxres'];
	}
	

	// reduce resources (user id, amount
	public function modifyUserResources($userID, $amount) {
		// get the user's current resources
		$currentResources = $this->getUserResources();
		$maxres = $this->getResourceLimit($userID);
		
		if($amount < 0) { // subtracting resources
			if(($currentResources - $amount) < 0) {
				$this->setResources($userID, 0);
			}
			else {
				$this->setResources($userID, $currentResources - $amount);
			}
		}
		else {
			if(($currentResources + $maxres) > 100) {
				$this->setResources($userID, 100);
			}
			else {
				$this->setResources($userID, $currentResources + $amount);
			}
		}
	}
	
	// helper method for modifyUserResources
	public function setResources($userID, $value) {
		$this->database->query("UPDATE user SET resources = :max WHERE id  = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->bind(":max", $value);
		$this->database->execute();
	}
	
	public function setMaxResources($userID, $value) {
		$this->database->query("UPDATE user SET maxres = :max WHERE id  = :userID");
		$this->database->bind(":userID", $userID);
		$this->database->bind(":max", $value);
		$this->database->execute();
	}

	public function getUserAccessPointsSecurity($userID, $securityType) {
		$this->database->query("SELECT * FROM `aps` WHERE OWNER = :ownerID AND SECURITY = :security");
		$this->database->bind(":ownerID", $userID);
		$this->database->bind(":security", $securityType);
		$this->database->execute();
		return $this->database->rowCount();
	}
	
	public function getAP($apID) {
		$this->database->query("SELECT * FROM `aps` WHERE ID = :apID");
		$this->database->bind(":apID", $apID);
		$this->database->execute();
		return $this->database->fetchResult();
	}

	public function setAccessPointOwner($apID, $userID) {
		$this->database->query("UPDATE `aps` SET OWNER = :userID WHERE ID = :apID");
		$this->database->bind(":userID", $userID);
		$this->database->bind(":apID", $apID);
		$this->database->execute();
	}

	// new orders
	public function getOrders() {
		$this->database->query("SELECT * FROM orders");
		$this->database->execute();
		return $this->database->fetchResultSet();
	}

	public function addHack($apID, $userID) {
		$this->database->query("INSERT INTO orders (apid, uid) VALUES (:apID, :uID)");
		$this->database->bind(":apID", $apID);
		$this->database->bind(":uID", $userID);
		$this->database->execute();
	}

	public function clearOrders() {
		$this->database->query("TRUNCATE TABLE orders");
		$this->database->execute();
	}

	public function getUserID($username) {
		$this->database->query("SELECT id FROM user WHERE username = :username");
		$this->database->bind(":username", $username);
		$this->database->execute();
		$res = $this->database->fetchResult();
		return $res['id'];
	}
}


//$api = new DataAPI();
