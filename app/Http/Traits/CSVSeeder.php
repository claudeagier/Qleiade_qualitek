<?php

namespace App\Http\Traits;

trait CSVSeeder {

	public function csv_to_array($filename = '', $delimiter = ',') {
		if (!file_exists($filename) || !is_readable($filename))
			return FALSE;

		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
				if (!$header) {
					$header = $row;
					$header[] = "created_at";
				}
				else {
					// $toto = array_combine($header, $row);
					// $toto["created_at"] = now()->format('Y-m-d H:i:s');
					$row[] = now();
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}
		// dd($data);
		return $data;
	}

}