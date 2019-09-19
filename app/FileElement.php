<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileElement extends Model{


	protected $table = 'file_elements';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"name", "parent_id", "type"
	];


	public function parent(){
		return $this->belongsTo(self::class, 'parent_id');
	}

	public function children(){
		return $this->hasMany(self::class, 'parent_id');
    }

    public function projectReports(){
        return $this->belongsToMany("App\ProjectReport");
    }

	public static function boot(){
		parent::boot();

		// Handling cascading delete of fileElement
		static::deleting(function($fileElement){
			if ($fileElement->type === 'd') {
				$fileElement->children()->get()->each(function($fileElement){
					$fileElement->delete();
				});
			}
		});
	}
	// set the relationship between the file and the components that are using this file
	// while deleting, we need to set the id column of on the child component to null
}
