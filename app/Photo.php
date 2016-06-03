<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $table = 'match_photos';

	protected $fillable = ['match_id', 'filename'];

	public function setAttributes($match)
	{
		$this->setFileName($match);
		$this->setDestinationDirectory();
		$this->match_id = $match->id;
	}

	public function setFileName($match)
	{
		$this->filename = 'match_photo_' . $match->id . '.' . $this->file->getClientOriginalExtension();
	}

	public function setDestinationDirectory()
	{
		$this->destinationDir = storage_path() . env('PHOTO_STORAGE_DIR');
	}

	public function setFile($file)
	{
		$this->file = $file;
	}

	public function moveFile()
	{
		$this->file->move($this->destinationDir, $this->filename);
	}
}
