<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceMapping;
use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\User;
use DB;
use Eloquent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ApiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Sync/Index');
    }
    private function unitChanger($string)
    {
        switch ($string) {
            case 'FTIB':
                return strtoupper('Fakultas Teknologi Informasi dan Bisnis');
                break;
            case 'FTEIC':
                return strtoupper('Fakultas Teknologi Elektro dan Industri Cerdas');
                break;
            default:
                return $string;
                break;
        }
    }
    private function urlToJson($obj)
    {
        $response = Http::withHeaders([
            // 'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])
            ->withOptions(['timeout' => 6000])
            ->get($obj->url);

        $endresponse = $response->json();
        $endresponse = json_encode($endresponse);
        return $endresponse;
    }
    private function objIndextoString($arr)
    {
        $arr = json_decode(json_encode(($arr)), true);
        return array_keys($arr);
    }
    private function toDate($string)
    {
        return date("Y-m-d", strtotime($string));
    }
    // MAKE SQL FUNC
    private function makeDeleteList($obj)
    {
        // parse needed variable
        $refvalue = (string) $obj->refvalue;
        $data = json_decode(json_encode($obj->data), true);
        // start the query generator
        $sqlDeleteList = "";
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=0;\n";
        foreach ($data as $dl) {
            $sqlDeleteList .= "DELETE FROM `{$obj->table}` WHERE `{$obj->reference}`";
            $sqlDeleteList .= "='$dl[$refvalue]'";
            if ($obj->nocreated == false) {
                $sqlDeleteList .= "AND `createdby` =  '999'";
                $sqlDeleteList .= "AND `updatedby` =  null";
            }
            $sqlDeleteList .= ";\n";

        }
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sqlDeleteList = $sqlDeleteList . "\n";
        // return the result
        return $sqlDeleteList;
    }
    private function makeDeleteListbyService($obj)
    {
        // parse needed variable
        $refvalue = (string) $obj->refvalue;
        $data = json_decode(json_encode($obj->data), true);
        // start the query generator
        $sqlDeleteList = "";
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=0;\n";
        foreach ($data as $dl) {
            $idd = Service::select()->where('service', $dl['optname'])->first();
            $idd = $idd->id;
            $sqlDeleteList .= "DELETE FROM `{$obj->table}` WHERE `{$obj->reference}`";
            $sqlDeleteList .= "='$idd'";
            $sqlDeleteList .= " AND `createdby` =  '999'";
            $sqlDeleteList .= " AND `updatedby` =  null;\n";

        }
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sqlDeleteList = $sqlDeleteList . "\n";
        // return the result
        return $sqlDeleteList;
    }
    private function makeDeleteListbyPerson($obj)
    {
        // parse needed variable
        $refvalue = (string) $obj->refvalue;
        $data = json_decode(json_encode($obj->data), true);
        // start the query generator
        $sqlDeleteList = "";
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=0;\n";
        foreach ($data as $dl) {
            if ($dl['useras'] == 'MAHASISWA') {
                if (strpos($dl['userunit'], '+')) {
                    $idd = Person::select()->where('per_id', $dl['userid'])->first();
                    if (isset($idd->id)) {
                        $idd = $idd->id;
                        $sqlDeleteList .= "DELETE FROM `{$obj->table}` WHERE `{$obj->reference}`";
                        $sqlDeleteList .= "='$idd'";
                        $sqlDeleteList .= " AND `createdby` =  '999'";
                        $sqlDeleteList .= " AND `updatedby` =  null;\n";
                    }
                }
            } else if ($dl['useras'] !== 'MAHASISWA') {
                $idd = Person::select()->where('per_id', $dl['usernum'])->first();
                // print_r($dl);
                if (isset($idd->id)) {
                    $idd = $idd->id;
                    $sqlDeleteList .= "DELETE FROM `{$obj->table}` WHERE `{$obj->reference}`";
                    $sqlDeleteList .= "='$idd'";
                    $sqlDeleteList .= " AND `createdby` =  '999'";
                    $sqlDeleteList .= " AND `updatedby` =  null;\n";
                }
            }
        }
        $sqlDeleteList .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sqlDeleteList = $sqlDeleteList . "\n";
        // return the result
        return $sqlDeleteList;
    }
    private function makeInsertList($obj)
    {
        // parse needed variable
        $refvalue = (string) $obj->refvalue;
        $data = json_decode(json_encode($obj->data), true);
        // start the query generator
        $sqlInsertList = "INSERT INTO `{$obj->table}`({$obj->field}) \n VALUES";
        foreach ($data as $dl) {
            $dl[$refvalue] = $this->unitChanger($dl[$refvalue]);
            $sqlInsertList .= "('$dl[$refvalue]', {$obj->constvalue}),\n";
        }
        $sqlInsertList = rtrim($sqlInsertList, "\n,");
        $sqlInsertList = $sqlInsertList . ";\n\n";
        return $sqlInsertList;
    }
    private function makeUpdateList($obj)
    {
        // parse needed variable
        $refvalue = (string) $obj->refvalue;
        $data = json_decode(json_encode($obj->data), true);
        // start the query generator
        $sqlUpdateList = "";

        foreach ($data as $key => $dl) {
            $dl[$refvalue] = $this->unitChanger($dl[$refvalue]);
            foreach ($obj->fieldref as $key => $value) {
                $val = explode(',', $value);
                $check = DB::table($obj->table)->where("{$val[0]}", "{$dl[$val[1]]}")->first();
                if (isset($check)) {
                    $sqlUpdateList .= "UPDATE `{$obj->table}` set ";
                    $sqlUpdateList .= "`{$val[0]}`='{$dl[$val[1]]}' ";
                    $sqlUpdateList .= "WHERE `{$obj->reference}`='{$dl[$refvalue]}';\n";
                } else {
                    $sqlUpdateList .= "INSERT INTO `{$obj->table}`({$obj->field}) \n VALUES";
                    $sqlUpdateList .= "(`{$val[0]}`='{$dl[$val[1]]}', createdby='999', created_at=CURRENT_TIMESTAMP);\n";
                }
            }
        }
        $sqlUpdateList = $sqlUpdateList . "\n";
        return $sqlUpdateList;
    }
    private function makeTruncateTable($obj)
    {
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "TRUNCATE `" . $obj->table . "`;\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $sql;

    }
    private function migrateSqlFile($obj)
    {
        // Migrate the data
        Eloquent::unguard();
        $path = storage_path() . '/app/public/sync/' . $obj->filename;
        return DB::unprepared(file_get_contents($path));

    }
    private function toSqlFile($obj)
    {
        $filename = $obj->name . date("YmdTHis") . '.sql';
        Storage::disk('sync')->put($filename, $obj->sql);
        return $filename;
    }

    private function getUnitData()
    {
        // $url = "http://localhost/ypt_xgracias_itts/api_account.php?f=getunit";
        $url = "https://igracias.ittelkom-sby.ac.id/api_account.php?f=getunit";
        // $token = 'this is da token';

        $urlObj = (object) ['url' => $url];
        return $this->urlToJson($urlObj);
    }
    public function syncUnitData()
    {
        $data = $this->getUnitData();
        $data = json_decode($data);
        $dataList = $data->units;

        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'units';
        $dataArr['field'] = '`unit`,`createdby`,`created_at`';
        $dataArr['fieldref'] = ['unit,orgname'];
        $dataArr['constvalue'] = "'999', CURRENT_TIMESTAMP";
        $dataArr['reference'] = 'unit';
        $dataArr['refvalue'] = 'orgname';
        $dataArr['nocreated'] = false;
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;

        $unit = Unit::select()->where('unit', 'LIKE', '%PRODI%')->get();
        if (isset($unit->toArray()[0])) {
            if (count($unit) > 3) {
                $sqlUpdateList = $this->makeUpdateList($dataObj);
                $sql = $sqlUpdateList;

                $toSqlObj = (object) ['name' => 'unit', 'sql' => $sql];
                $filename = $this->toSqlFile($toSqlObj);
                // migrate sql file to db
                $migrateSqlObj = (object) ['filename' => $filename];
                $this->migrateSqlFile($migrateSqlObj);
                // get data
                $sqlUpdateList = "";
                foreach ($dataList as $dl) {
                    $dl->orgparent = $this->unitChanger($dl->orgparent);
                    $dl->orgname = $this->unitChanger($dl->orgname);
                    $idd = Unit::select()->where('unit', $dl->orgparent)->first();
                    if (count($idd) > 0) {
                        $idd = (isset($idd) ? $idd->id : " ");
                        $sqlUpdateList .= "UPDATE `units` set ";
                        $sqlUpdateList .= "`unit_parent`='{$idd}' ";
                        $sqlUpdateList .= "WHERE `unit`='{$dl->orgname}';\n";
                    } else if (count($idd) == 0) {
                        $sqlUpdateList .= "INSERT INTO `units`(`unit`,`unit_parent`,`createdby`,`created_at`) \n VALUES";
                        $sqlUpdateList .= "('{$dl->orgname}', '0', '999', CURRENT_TIMESTAMP);\n";
                    }
                    // return print_r($dl);
                }

                $sql = $sqlUpdateList;

                // make file sql
                $toSqlObj = (object) ['name' => 'parentunit', 'sql' => $sql];
                $filename = $this->toSqlFile($toSqlObj);
                // migrate sql file to db
                $migrateSqlObj = (object) ['filename' => $filename];
                return $this->migrateSqlFile($migrateSqlObj);
            }
        } else {
            // Delete existing first
            $sqlDeleteList = $this->makeDeleteList($dataObj);
            // Insert new data
            $sqlInsertList = $this->makeInsertList($dataObj);
            // add to sql var
            $sql = $sqlDeleteList . $sqlInsertList;
            // make file sql
            $toSqlObj = (object) ['name' => 'unit', 'sql' => $sql];
            $filename = $this->toSqlFile($toSqlObj);
            // migrate sql file to db
            $migrateSqlObj = (object) ['filename' => $filename];
            $this->migrateSqlFile($migrateSqlObj);
            // get data
            $sqlUpdateList = "";
            foreach ($dataList as $dl) {
                $dl->orgparent = $this->unitChanger($dl->orgparent);
                $dl->orgname = $this->unitChanger($dl->orgname);
                $idd = Unit::select()->where('unit', $dl->orgparent)->first();
                // return print_r($dl);
                $idd = (isset($idd) ? $idd->id : " ");
                $sqlUpdateList .= "UPDATE `units` set ";
                $sqlUpdateList .= "`unit_parent`='{$idd}' ";
                $sqlUpdateList .= "WHERE `unit`='{$dl->orgname}';\n";
            }

            $sql = $sqlUpdateList;

            // make file sql
            $toSqlObj = (object) ['name' => 'parentunit', 'sql' => $sql];
            $filename = $this->toSqlFile($toSqlObj);
            // migrate sql file to db
            $migrateSqlObj = (object) ['filename' => $filename];
            return $this->migrateSqlFile($migrateSqlObj);
        }
    }

    private function getServiceData()
    {
        // $url = "http://localhost/ypt_xgracias_itts/api_account.php?f=getservice";
        $url = "https://igracias.ittelkom-sby.ac.id/api_account.php?f=getservice";
        // $token = 'this is da token';

        $urlObj = (object) ['url' => $url];
        return $this->urlToJson($urlObj);
    }
    public function syncServiceData()
    {
        $data = $this->getServiceData();
        $data = json_decode($data);
        // return print_r($data);
        $dataList = $data->services;

        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'services';
        $dataArr['fieldref'] = ['service,optname'];
        $dataArr['field'] = '`service`,`createdby`,`created_at`';
        $dataArr['constvalue'] = "'999', CURRENT_TIMESTAMP";
        $dataArr['reference'] = 'service';
        $dataArr['refvalue'] = 'optname';
        $dataArr['nocreated'] = false;
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;

        $unit = Service::select()->where('service', 'LIKE', '%Layanan%')->get();
        if (count($unit) > 3) {
            $sqlUpdateList = $this->makeUpdateList($dataObj);
            $sql = $sqlUpdateList;
        } else {
            $sqlDeleteList = $this->makeDeleteList($dataObj);
            $sqlInsertList = $this->makeInsertList($dataObj);
            // add to sql var
            $sql = $sqlDeleteList . $sqlInsertList;
        }
        // make file sql
        $toSqlObj = (object) ['name' => 'service', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);

        // return Redirect::to('/sync-service-mapping-data');
        // call the service mapping data
    }
    public function syncServiceMappingData()
    {
        $data = $this->getServiceData();
        $data = json_decode($data);
        // return print_r($data);
        $dataList = $data->services;

        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'service_mappings';
        $dataArr['field'] = '`service_id`,`unit_id`,`createdby`,`created_at`';
        $dataArr['constvalue'] = "'999', CURRENT_TIMESTAMP";

        $dataArr['fieldvalue'] = $this->objIndextoString($dataList[0]);
        $dataArr['reference'] = 'service_id';
        $dataArr['refvalue'] = 'optname';
        $dataArr['nocreated'] = false;
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;

        $sqlInsertList = '';
        $sqlUpdateList = '';
        foreach ($dataList as $dl) {
            $dl->optname = $this->unitChanger($dl->optname);
            $idd = Service::select()->where('service', $dl->optname)->first();
            $iddd = Unit::select()->where('unit', 'LIKE', '%' . $dl->optparent . '%')->first();
            $idd = $idd->id;
            $iddd = $iddd->id;
            $sermap = ServiceMapping::select()->where('service_id', $idd)->first();

            if (empty($sermap)) {
                // Make delete list
                $sqlDeleteList = $this->makeDeleteListbyService($dataObj);
                // special insert hence it needs new class inside foreach
                $sqlInsertList .= "INSERT INTO `service_mappings`(`service_id`,`unit_id`,`createdby`,`created_at`) \n VALUES";
                $sqlInsertList .= "('{$idd}','{$iddd}', '999', CURRENT_TIMESTAMP);\n";
                $sql = $sqlDeleteList . $sqlInsertList;

            } else {
                $sqlUpdateList .= "UPDATE `service_mappings` set ";
                $sqlUpdateList .= "`service_id`='{$idd}', ";
                $sqlUpdateList .= "`unit_id`='{$iddd}' ";
                $sqlUpdateList .= "WHERE `service_id`='{$idd}';\n";
                $sql = $sqlUpdateList;
            }

        }

        // make file sql
        $toSqlObj = (object) ['name' => 'servicexmapping', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);

    }
    private function getUserData()
    {
        // $url = "http://localhost/ypt_xgracias_itts/api_account.php?f=getuser";
        $url = "https://igracias.ittelkom-sby.ac.id/api_account.php?f=getuser";
        // $token = 'this is da token';

        $urlObj = (object) ['url' => $url];
        return $this->urlToJson($urlObj);
    }

    public function syncPeopleData()
    {
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
        $data = $this->getUserData();
        $data = json_decode($data);
        $dataList = $data->students;
        $dataList2 = $data->employees;
        // Data Mahasiswa
        // Delete existing first
        // Object for the ffunction
        $dataArr = [];
        // dd($dataList2);

        $dataArr['table'] = 'people';
        $dataArr['reference'] = 'per_num';
        $dataArr['refvalue'] = 'usernum';
        $dataArr['nocreated'] = true;
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;
        $unit = Person::select()->where('person', 'LIKE', '%Muhammad%')->get();
        $sqlUpdateList = "";
        $sqlUpdateList2 = "";
        if (count($unit) > 2) {
            foreach ($dataList as $dl) {
                if (strpos($dl->userunit, '+')) {
                    $dl->usernames = htmlspecialchars($dl->usernames);
                    $dl->usermail = htmlspecialchars($dl->usermail);
                    $idd = Person::select()->where('per_id', $dl->userid)->first();
                    $idd = isset($idd) ? $idd->toArray() : array();
                    if (count($idd) > 0) {
                        $sqlUpdateList .= "UPDATE `people` set ";
                        $sqlUpdateList .= "`person`='{$dl->usernames}', ";
                        $sqlUpdateList .= "`per_id`='{$dl->userid}', ";
                        $sqlUpdateList .= "`per_phone`='{$dl->userphone}', ";
                        $sqlUpdateList .= "`per_email`='{$dl->usermail}', ";
                        $sqlUpdateList .= "`per_group`='{$dl->useras}', ";
                        $sqlUpdateList .= "updated_at=CURRENT_TIMESTAMP ";
                        $sqlUpdateList .= "WHERE `per_num`='{$dl->usernum}';\n";
                    } else if (count($idd) == 0) {
                        $sqlUpdateList .= "INSERT INTO `people`(`person`,`per_num`,`per_id`,`per_phone`,`per_email`,`per_group`,`created_at`) \n VALUES";
                        $sqlUpdateList .= "('{$dl->usernames}', '{$dl->userid}', '{$dl->usernum}', '{$dl->userphone}', '{$dl->usermail}',";
                        $sqlUpdateList .= "'{$dl->useras}', CURRENT_TIMESTAMP);\n";
                    }
                }
            }
            $dataArr['data'] = $dataList2;

            $dataObj = (object) $dataArr;
            // Delete existing first
            // Insert new data
            foreach ($dataList2 as $dl) {
                $dl->userid = substr_replace($dl->userid, '', -2);
                $dl->usernames = htmlspecialchars($dl->usernames);
                $dl->usermail = htmlspecialchars($dl->usermail);
                $idd = Person::select()->where('per_id', $dl->usernames)->first();
                $idd = isset($idd) ? $idd->toArray() : array();
                if (count($idd) > 0) {
                    $sqlUpdateList2 .= "UPDATE `people` set ";
                    $sqlUpdateList2 .= "`person`='{$dl->usernames}', ";
                    $sqlUpdateList2 .= "`per_id`='{$dl->userid}', ";
                    $sqlUpdateList2 .= "`per_phone`='{$dl->userphone}', ";
                    $sqlUpdateList2 .= "`per_email`='{$dl->usermail}', ";
                    $sqlUpdateList2 .= "`per_group`='{$dl->useras}', ";
                    $sqlUpdateList2 .= "updated_at=CURRENT_TIMESTAMP ";
                    $sqlUpdateList2 .= "WHERE `per_num`='{$dl->usernum}';\n";
                } else if (count($idd) == 0) {
                    $sqlUpdateList2 .= "INSERT INTO `people`(`person`,`per_num`,`per_id`,`per_phone`,`per_email`,`per_group`,`created_at`) \n VALUES";
                    $sqlUpdateList2 .= "('{$dl->usernames}', '{$dl->userid}', '{$dl->usernum}', '{$dl->userphone}', '{$dl->usermail}',";
                    $sqlUpdateList2 .= "'{$dl->useras}', CURRENT_TIMESTAMP);\n";
                }
            }

            $sql = $sqlUpdateList . $sqlUpdateList2;
        } else {
            $sqlDeleteList = $this->makeDeleteList($dataObj);
            // Insert new data
            $sqlInsertList = "INSERT INTO `people`(`person`,`per_num`,`per_id`,`per_phone`,`per_email`,`per_group`,`created_at`) \n VALUES";
            foreach ($dataList as $dl) {
                if (strpos($dl->userunit, '+')) {
                    $dl->usernames = htmlspecialchars($dl->usernames);
                    $dl->usermail = htmlspecialchars($dl->usermail);
                    $sqlInsertList .= "('{$dl->usernames}', '{$dl->userid}', '{$dl->usernum}', '{$dl->userphone}', '{$dl->usermail}',";
                    $sqlInsertList .= "'{$dl->useras}', CURRENT_TIMESTAMP),\n";
                }

            }
            $sqlInsertList = rtrim($sqlInsertList, "\n,");
            $sqlInsertList = $sqlInsertList . ";\n\n";
            $dataArr['data'] = $dataList2;

            $dataObj = (object) $dataArr;
            // Delete existing first
            $sqlDeleteList2 = $this->makeDeleteList($dataObj);
            // Insert new data
            $sqlInsertList2 = "INSERT INTO `people`(`person`,`per_num`,`per_id`,`per_phone`,`per_email`,`per_group`,`created_at`) \n VALUES";
            foreach ($dataList2 as $dl) {
                $dl->userid = substr_replace($dl->userid, '', -2);
                $dl->usernames = htmlspecialchars($dl->usernames);
                $dl->usermail = htmlspecialchars($dl->usermail);
                $sqlInsertList2 .= "('{$dl->usernames}', '{$dl->userid}', '{$dl->usernum}', '{$dl->userphone}', '{$dl->usermail}',";
                $sqlInsertList2 .= " '{$dl->useras}', CURRENT_TIMESTAMP),\n";
            }
            $sqlInsertList2 = rtrim($sqlInsertList2, "\n,");
            $sqlInsertList2 = $sqlInsertList2 . ";\n\n";

            $sql = $sqlDeleteList . $sqlInsertList . $sqlDeleteList2 . $sqlInsertList2;
        }
        // dd($sql);
        // Delete existing first

        // return print_r($sql);
        // make file sql
        $toSqlObj = (object) ['name' => 'people', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);
    }

    public function syncUserData()
    {
        ini_set('max_execution_time', 1000); //300 seconds = 5 minutes
        $data = $this->getUserData();
        $data = json_decode($data);
        $dataList = $data->students;
        $dataList2 = $data->employees;
        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'users';
        $dataArr['reference'] = 'person_id';
        $dataArr['refvalue'] = 'userid';
        $dataArr['nocreated'] = true;
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;

        $unit = User::select()->where('username', 'LIKE', '20%')->get();
        $sqlUpdateList = "";
        $sqlUpdateList2 = "";
        if (count($unit) > 2) {
            foreach ($dataList as $dl) {
                if (strpos($dl->userunit, '+')) {
                    $dl->userpassword = Hash::make($dl->userpassword);
                    $check = User::select()->where('username', $dl->usernum)->first() || null;
                    if ($check) {
                        $sqlUpdateList .= "UPDATE `users` set ";
                        $sqlUpdateList .= "`username`='{$dl->usernum}', ";
                        $sqlUpdateList .= "`password`='{$dl->userpassword}', ";
                        $sqlUpdateList .= "updated_at=CURRENT_TIMESTAMP ";
                        $sqlUpdateList .= "WHERE `username`='{$dl->usernum}';\n";
                    } else {
                        $idd = Person::select()->where('per_id', $dl->usernum)->first();
                        if ($idd === null) {
                            $dl->usernames = htmlspecialchars($dl->usernames);
                            $dl->usermail = htmlspecialchars($dl->usermail);
                            $sqlInsertList = ["person" => "$dl->usernames", "per_num" => $dl->userid, "per_id" => $dl->usernum, "per_phone" => "$dl->userphone", "per_email" => "$dl->usermail", "per_group" => "$dl->useras"];
                            $newPerson = Person::create($sqlInsertList);
                            $pid = Person::select()->where('per_id', $dl->usernum)->first();
                            $pid = $pid->id;
                        } else {
                            $pid = $idd->id;
                        }
                        $sqlUpdateList .= "INSERT INTO `users`(`person_id`,`username`,`password`,`created_at`) \n VALUES";
                        $sqlUpdateList .= "('$pid','{$dl->usernum}','{$dl->userpassword}',CURRENT_TIMESTAMP);\n";
                    }
                }
            }
            $dataArr['data'] = $dataList2;

            $dataObj = (object) $dataArr;
            // Delete existing first
            // Insert new data
            foreach ($dataList2 as $dl) {
                $dl->userid = substr_replace($dl->userid, '', -2);
                $dl->userpassword = Hash::make($dl->userpassword);
                $check = User::select()->where('username', $dl->usernum)->first();
                if ($check) {
                    $sqlUpdateList2 .= "UPDATE `users` set ";
                    $sqlUpdateList2 .= "`username`='{$dl->userid}', ";
                    $sqlUpdateList2 .= "`password`='{$dl->userpassword}', ";
                    $sqlUpdateList2 .= "updated_at=CURRENT_TIMESTAMP ";
                    $sqlUpdateList2 .= "WHERE `username`='{$dl->usernum}';\n";
                } else {
                    $idd = Person::select()->where('per_id', $dl->usernum)->first();
                    if ($idd === null) {
                        $dl->usernames = htmlspecialchars($dl->usernames);
                        $dl->usermail = htmlspecialchars($dl->usermail);
                        $sqlInsertList = ["person" => "$dl->usernames", "per_num" => $dl->userid, "per_id" => $dl->usernum, "per_phone" => "$dl->userphone", "per_email" => "$dl->usermail", "per_group" => "$dl->useras"];
                        $newPerson = Person::create($sqlInsertList);
                        $pid = Person::select()->where('per_id', $dl->usernum)->first();
                        $pid = $pid->id;
                    } else {
                        $pid = $idd->id;
                    }
                    $sqlUpdateList2 .= "INSERT INTO `users`(`person_id`,`username`,`password`,`created_at`) \n VALUES";
                    $sqlUpdateList2 .= "('$pid','{$dl->usernum}','{$dl->userpassword}',CURRENT_TIMESTAMP);\n";
                }
            }
            $sql = $sqlUpdateList . $sqlUpdateList2;
        } else {
            $sqlDeleteList = $this->makeDeleteList($dataObj);
            $sqlInsertList = "INSERT INTO `users`(`person_id`,`username`,`password`,`created_at`) \n VALUES";
            foreach ($dataList as $dl) {
                $dl->userpassword = Hash::make($dl->userpassword);
                if (strpos($dl->userunit, '+')) {
                    $idd = Person::select()->where('per_id', $dl->usernum)->first();
                    $idd = $idd->id;
                    $sqlInsertList .= "('{$idd}','{$dl->usernum}','{$dl->userpassword}',CURRENT_TIMESTAMP),\n";
                }
            }
            $sqlInsertList = rtrim($sqlInsertList, "\n,");
            $sqlInsertList = $sqlInsertList . ";\n\n";

            $dataArr['data'] = $dataList2;
            $dataObj = (object) $dataArr;
            $sqlDeleteList2 = $this->makeDeleteList($dataObj);
            $sqlInsertList2 = "INSERT INTO `users`(`person_id`,`username`,`password`,`created_at`) \n VALUES";
            foreach ($dataList2 as $dl) {
                $dl->userid = substr_replace($dl->userid, '', -2);
                $dl->userpassword = Hash::make($dl->userpassword);
                $idd = Person::select()->where('per_id', $dl->usernum)->first();

                $idd = $idd->id;
                $sqlInsertList2 .= "('{$idd}','{$dl->userid}','{$dl->userpassword}',CURRENT_TIMESTAMP),\n";

            }
            $sqlInsertList2 = rtrim($sqlInsertList2, "\n,");
            $sqlInsertList2 = $sqlInsertList2 . ";\n\n";

            $sql = $sqlDeleteList . $sqlInsertList . $sqlDeleteList2 . $sqlInsertList2;
        }
        // make file sql
        $toSqlObj = (object) ['name' => 'users', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);
    }
    // work on this next
    public function syncUnitPeopleData()
    {
        $data = $this->getUserData();
        $data = json_decode($data);
        $dataList = $data->students;
        $dataList2 = $data->employees;
        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'unit_people';
        $dataArr['reference'] = 'person_id';
        $dataArr['refvalue'] = 'per_id';
        $dataArr['nocreated'] = false;
        // Data Mahasiswa
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;
        // Delete existing first
        // $sqlDeleteList = $this->makeDeleteListbyPerson($dataObj);
        $sqlDeleteList = "SET FOREIGN_KEY_CHECKS=0;\n";
        $sqlDeleteList .= 'TRUNCATE TABLE `unit_people`;';
        $sqlDeleteList .= "\nSET FOREIGN_KEY_CHECKS=1;\n\n";

        // special insert hence it needs new class inside foreach
        $sqlInsertList = "INSERT INTO `unit_people`(`person_id`,`unit_id`,`position`, `start_date`,`createdby`,`created_at`) \n VALUES";
        foreach ($dataList as $dl) {
            if (strpos($dl->userunit, '+')) {
                // Adjust Var
                $dl->userunit = $this->unitChanger($dl->userunit);
                $dl->useryear = '01-OCT-' . substr($dl->useryear, 0, 2);
                $arrUnit = explode('+', $dl->userunit);
                $dl->userunit = "PRODI " . $arrUnit[1];
                // get ID
                $idd = Unit::select()->where('unit', 'LIKE', $dl->userunit . '%')->first();
                $idd = $idd->id;
                $idd2 = Person::select()->where('per_id', $dl->usernum)->first();
                if ($idd2 !== null) {
                    $idd2 = $idd2->id;
                    $sqlInsertList .= "('{$idd2}','{$idd}','{$dl->useras}','{$this->toDate($dl->useryear)}', '999', CURRENT_TIMESTAMP),\n";
                }

            }
        }
        $sqlInsertList = rtrim($sqlInsertList, "\n,");
        $sqlInsertList = $sqlInsertList . ";\n\n";

        // Data Pegawai
        $dataArr['data'] = $dataList2;

        $dataObj = (object) $dataArr;
        // Delete existing first
        // $sqlDeleteList = $this->makeDeleteListbyPerson($dataObj);

        // special insert hence it needs new class inside foreach
        $sqlInsertList2 = "INSERT INTO `unit_people`(`person_id`,`unit_id`,`position`, `start_date`,`createdby`,`created_at`) \n VALUES";
        foreach ($dataList2 as $dl) {
            if ($dl->useras !== 'DOSEN LUAR BIASA') {
                $dl->userunit = $this->unitChanger($dl->userunit);
                $idd = Unit::select()->where('unit', 'LIKE', '%' . $dl->userunit . '%')->first();
                $idd = $idd->id;
                $idd2 = Person::select()->where('per_id', $dl->usernum)->first();
                if ($idd2 !== null) {
                    $idd2 = $idd2->id;
                    // print_r($dl);
                    $sqlInsertList2 .= "('{$idd2}','{$idd}','{$dl->useras}','{$this->toDate($dl->useryear)}', '999', CURRENT_TIMESTAMP),\n";
                }
            }
        }
        $sqlInsertList2 = rtrim($sqlInsertList2, "\n,");
        $sqlInsertList2 = $sqlInsertList2 . ";\n\n";

        $sql = $sqlDeleteList . $sqlInsertList . $sqlInsertList2;
        // return print_r($sql);

        // make file sql
        $toSqlObj = (object) ['name' => 'userxunit', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);
    }

    public function syncRolePeopleData()
    {
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $data = $this->getUserData();
        $data = json_decode($data);
        $dataList = $data->students;
        $dataList2 = $data->employees;
        // Object for the ffunction
        $dataArr = [];

        $dataArr['table'] = 'person_role_mappings';
        $dataArr['reference'] = 'person_id';
        $dataArr['refvalue'] = 'usernum';
        $dataArr['nocreated'] = false;
        // Data Mahasiswa
        $dataArr['data'] = $dataList;

        $dataObj = (object) $dataArr;

        // Delete existing first
        // dd($dataObj->data);
        $sqlDeleteList = $this->makeDeleteListbyPerson($dataObj);

        // special insert hence it needs new class inside foreach
        $sqlInsertList = "";
        foreach ($dataList as $dl) {
            if (strpos($dl->userunit, '+')) {
                // Adjust Var
                // get ID
                $idd = Person::select('*')->where('per_id', $dl->userid)->first();
                if ($idd !== null) {
                    $sqlInsertList .= "INSERT INTO `person_role_mappings`(`person_id`,`role_id`,`createdby`,`created_at`) \n VALUES";
                    $idd = $idd->id;
                    // get the role rule
                    switch ($dl->userroles) {
                        case 'MAHASISWA':
                            $idd2 = Role::select()->where('role', 'Pengguna')->first();
                            $idd2 = $idd2->id;
                            $sqlInsertList .= "('{$idd}','{$idd2}', '999', CURRENT_TIMESTAMP),\n";
                            // For the administrator
                            if (in_array($dl->usernum, petugasArr())) {
                                $idd2 = Role::select()->where('role', 'Petugas')->first();
                                $idd2 = $idd2->id;
                                $sqlInsertList .= "('{$idd}','{$idd2}', '999', CURRENT_TIMESTAMP),\n";
                            }
                            break;
                        }
                    }
                    $sqlInsertList = rtrim($sqlInsertList, ",\n").";\n";
            }
        }
        $sqlInsertList = rtrim($sqlInsertList, "\n,");
        // $sqlInsertList = $sqlInsertList . ";\n\n";
        // dd('ok');
        // return dd($sqlDeleteList, $sqlInsertList);

        // Data Pegawai
        $dataArr['data'] = $dataList2;

        $dataObj = (object) $dataArr;
        // Delete existing first
        $sqlDeleteList2 = $this->makeDeleteListbyPerson($dataObj);

        // special insert hence it needs new class inside foreach
        $sqlInsertList2 = "INSERT INTO `person_role_mappings`(`person_id`,`role_id`,`createdby`,`created_at`) \n VALUES";
        foreach ($dataList2 as $dl) {
            // Adjust Var
            // get ID
            $idd = Person::select()->where('per_id', $dl->usernum)->first();
            // print_r($dl);
            if (isset($idd->id)) {
                $idd = $idd->id;

                $idd2 = UnitPeople::select()->where('person_id', $idd)->where('position', 'TPA')->orwhere('person_id', $idd)->where('position', 'TKWT')->first();
                $arrAccess = explode(',', $dl->userroles);

                foreach ($arrAccess as $aa) {
                    if (str_contains($aa, 'DOSEN') || str_contains($aa, 'PEGAWAI')) {
                        $idd3 = Role::select()->where('role', 'Pengguna')->first();
                        $idd3 = $idd3->id;
                        $insert = "('{$idd}','{$idd3}', '999', CURRENT_TIMESTAMP),";
                        if (str_contains($sqlInsertList2, $insert) == false) {
                            $sqlInsertList2 .= $insert . "\n";
                        }
                    } elseif (str_contains($aa, 'REKTOR')) {
                        $idd3 = Role::select()->where('role', 'Pengamat')->first();
                        $idd3 = $idd3->id;
                        $insert = "('{$idd}','{$idd3}', '999', CURRENT_TIMESTAMP),";
                        if (str_contains($sqlInsertList2, $insert) == false) {
                            $sqlInsertList2 .= $insert . "\n";
                        }
                    } elseif (str_contains($aa, 'SUPERADMIN')) {
                        $idd3 = Role::select()->where('role', 'Pengurus')->first();
                        $idd3 = $idd3->id;
                        $insert = "('{$idd}','{$idd3}', '999', CURRENT_TIMESTAMP),";
                        if (str_contains($sqlInsertList2, $insert) == false) {
                            $sqlInsertList2 .= $insert . "\n";
                        }
                    } elseif (str_contains($dl->useras, 'KEPALA BAGIAN') || str_contains($dl->useras, 'KEPALA URUSAN')) {
                        $idd3 = Role::select()->where('role', 'Pemimpin')->first();
                        $idd3 = $idd3->id;
                        $insert = "('{$idd}','{$idd3}', '999', CURRENT_TIMESTAMP),";
                        if (str_contains($sqlInsertList2, $insert) == false) {
                            $sqlInsertList2 .= $insert . "\n";
                        }
                    } elseif (isset($idd2->id)) {
                        $idd3 = Role::select()->where('role', 'Pelaksana')->first();
                        $idd3 = $idd3->id;
                        $insert = "('{$idd}','{$idd3}', '999', CURRENT_TIMESTAMP),";
                        if (str_contains($sqlInsertList2, $insert) == false) {
                            $sqlInsertList2 .= $insert . "\n";
                        }
                    }
                }
            }
        }
        $sqlInsertList2 = rtrim($sqlInsertList2, "\n,");
        $sqlInsertList2 = $sqlInsertList2 . ";\n\n";

        // $sql = $sqlDeleteList . $sqlInsertList;
        $sql = $sqlInsertList ;
        $sql2 = $sqlDeleteList2 . $sqlInsertList2;

        $toSqlObj = (object) ['name' => 'deletemahasiswaxrole', 'sql' => $sqlDeleteList];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        $this->migrateSqlFile($migrateSqlObj);

        $toSqlObj = (object) ['name' => 'mahasiswaxrole', 'sql' => $sql];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        $this->migrateSqlFile($migrateSqlObj);

        // make file sql
        $toSqlObj = (object) ['name' => 'pegawaixrole', 'sql' => $sql2];
        $filename = $this->toSqlFile($toSqlObj);
        // migrate sql file to db
        $migrateSqlObj = (object) ['filename' => $filename];
        return $this->migrateSqlFile($migrateSqlObj);
    }
    public function test()
    {
        phpinfo();

    }
    // Sync All
    public function syncAllData()
    {
        ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
        $this->syncPeopleData();
        $this->syncUserData();
        $this->syncServiceData();
        $this->syncUnitData();
        $this->syncServiceMappingData();
        $this->syncUnitPeopleData();
        $this->syncRolePeopleData();
    }
}
