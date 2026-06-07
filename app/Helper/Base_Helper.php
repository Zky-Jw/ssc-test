<?php

use App\Models\Person;
use App\Models\PersonRoleMapping;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Function toShorten
 *
 * This function takes an input text and a count as parameters and returns a shortened version of the text.
 *
 * @param string $text The input text that needs to be shortened.
 * @param int $count The maximum number of characters allowed in the shortened text.
 * @return string The shortened text.
 */
function toShorten($text, $count)
{
    $text = strip_tags($text);
    if (strlen($text) > $count) {
        $text = substr($text, 0, $count);
        $text = substr($text, 0, strrpos($text, " "));
        $etc = " ...";
        $text = $text . $etc;
    }
    return $text;
}

/**
 * Function toTitle
 *
 * This function takes an input text and converts it to title case.
 *
 * @param string $text The input text that needs to be converted to title case.
 * @return string The input text converted to title case.
 */
function toTitle($text)
{
    $text = ucwords(strtolower($text));
    $text = preg_replace_callback('/\b[A-Z]{2,}\b/', function ($match) {
        return strtoupper($match[0]);
    }, $text);
    $text = preg_replace_callback('/\bFtib\b/', function ($match) {
        return strtoupper($match[0]);
    }, $text);
    $text = preg_replace_callback('/\bFtiec\b/', function ($match) {
        return strtoupper($match[0]);
    }, $text);
    $text = preg_replace_callback('/\bFtii\b/', function ($match) {
        return strtoupper($match[0]);
    }, $text);
    $text = preg_replace_callback('/\bFtte\b/', function ($match) {
        return strtoupper($match[0]);
    }, $text);

    return $text;
}

/**
 * Function toClass
 *
 * This function takes an input text and converts it to class format.
 *
 * @param string $text The input text that needs to be converted to class format.
 * @return string The input text converted to class format.
 */
function toClass($text)
{
    $text = strtolower($text);
    $text = str_replace(' ', '-', $text);
    return $text;
}

/**
 * Function toWa
 *
 * This function takes an input phone number and modifies it.
 *
 * @param string $text The input phone number that needs to be modified.
 * @return string The modified phone number.
 */
function toWa($text)
{
    $text = substr($text, 0, 2) == '08' ? '628' . substr($text, 1) : $text;
    return $text;
}

/**
 * Converts a given date into Indonesian format.
 *
 * @param string $date The date to be converted (in 'Y-m-d' format).
 * @return string The formatted Indonesian date (e.g., "15 Januari 2022").
 */
function toIndoDate($date)
{
    $date = date('Y-m-d', strtotime($date));
    $BulanIndo = array(
        "Januari", "Februari", "Maret",
        "April", "Mei", "Juni",
        "Juli", "Agustus", "September",
        "Oktober", "November", "Desember"
    );
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    return ($result);
}

/**
 * Converts a given month number into Indonesian format.
 *
 * @param int $month The month number to be converted.
 * @return string The formatted Indonesian month name (e.g., "Maret").
 */
function toIndoMonth($month)
{
    $BulanIndo = array(
        "Januari", "Februari", "Maret",
        "April", "Mei", "Juni",
        "Juli", "Agustus", "September",
        "Oktober", "November", "Desember"
    );
    $bulan = $month;
    $result = $BulanIndo[(int) $bulan - 1];
    return ($result);
}

/**
 * Function to get the faculty based on the major.
 *
 * @param string $major The major for which the faculty needs to be determined.
 * @return string The faculty name corresponding to the provided 'major' parameter.
 * If 'major' does not match any of the cases, "Fakultas tidak ditemukan" is returned.
 */
function getFaculty($major)
{
    $faculty = array("FAKULTAS TEKNOLOGI INFORMASI DAN BISNIS", "FAKULTAS TEKNOLOGI ELEKTRO DAN INDUSTRI CERDAS");
    $major = strtoupper($major);
    switch ($major) {
        case "PRODI TEKNIK ELEKTRO S1":
        case "PRODI TEKNIK TELEKOMUNIKASI S1":
        case "PRODI TEKNIK INDUSTRI S1":
        case "PRODI TEKNIK KOMPUTER S1":
        case "PRODI TEKNIK ELEKTRO S1":
        case "PRODI TEKNIK LOGISTIK S1":
            return $faculty[1];
            break;
        case "PRODI BISNIS DIGITAL S1":
        case "PRODI SAINS DATA S1":
        case "PRODI INFORMATIKA S1":
        case "PRODI SISTEM INFORMASI S1":
        case "PRODI REKAYASA PERANGKAT LUNAK S1":
        case "PRODI TEKNOLOGI INFORMASI S1":
            return $faculty[0];
            break;
        default:
            return "Fakultas tidak ditemukan";
            break;
    }
}

function randomString($length)
{
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

/**
 * Function to retrieve user data based on the parameter value.
 *
 * @param string $param The parameter to retrieve user data.
 * @return mixed The user ID if the user is authenticated and 'param' is equal to 'userid'.
 * "User tidak ditemukan" if the user is not authenticated.
 * "Parameter tidak ditemukan" if 'param' is null.
 * The value of the 'param' key from the user data array.
 */
function userdata($param)
{
    if (Auth::user() === null) {
        throw new Exception("User tidak ditemukan");
    }
    if ($param === null) {
        throw new Exception("Parameter tidak ditemukan");
    }
    if ($param === 'userid') {
        return Auth::user()->id;
    }
    $person = Person::find(Auth::user()->person_id);

    if (!$person) {
        return null;
    }

    $userdata = $person->toArray();
    if (array_key_exists($param, $userdata)) {
        return $userdata[$param];
    } else {
        return null;
    }
}
//
function userrole($person_id = null)
{
    if ($person_id === null) {
        $person_id = Auth::user()->person_id;
    }
    if (Auth::user() === null) {
        throw new Exception("User tidak ditemukan");
    }
    // get log eloquent query
    $privilege = PersonRoleMapping::select('people.id', 'people.person', DB::raw('GROUP_CONCAT(roles.id ORDER BY roles.id SEPARATOR ",") as roleIds'), DB::raw('GROUP_CONCAT(roles.role  ORDER BY roles.id SEPARATOR ",") as roleList'))
        ->join('roles', 'roles.id', '=', 'person_role_mappings.role_id')
        ->join('people', 'people.id', '=', 'person_role_mappings.person_id')
        ->groupby('people.id')
        ->where('people.id', $person_id)
        ->get();
    $userrole = [];
    foreach ($privilege as $key => $value) {
        $userrole[] = $value->roleIds;
    }

    // if user role is empty return 0
    if (empty($userrole)) {
        return 0;
    }
    // make user role to array
    $userrole = explode(',', $userrole[0]);
    return $userrole;
}

function petugasArr()
{
    $petugasArr = [
        '1204200232', '1205210081', '1205210014', '1201222013',
        '1204228117', '1204200088', '1204210017', '1205210025',
        '1204200011', '1204200032', '1205210022', '1206220008',
    ];
    return $petugasArr;
}

function calculate_due_date($ticket): ?string
{
    $createdAt = $ticket->created_at ?? null;
    $serviceId = $ticket->purpose['service']['id'] ?? null;

    if (!$createdAt || !$serviceId) {
        return null;
    }

    $service = \App\Models\ServiceAdditional::find($serviceId);
    $duration = $service?->duration;

    if (!$duration) {
        return null;
    }

    $date = Carbon::parse($createdAt);
    $time = $date->format('H:i:s'); // simpan waktu aslinya
    $added = 0;

    while ($added < $duration) {
        $date->addDay();
        if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
            $added++;
        }
    }

    // Gabungkan tanggal baru + waktu asli
    return $date->format('Y-m-d') . ' ' . $time;
}