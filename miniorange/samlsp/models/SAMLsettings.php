<?php namespace Miniorange\Samlsp\Models;

use Model;
use Response;

/**
 * Model
 */
class samlsettings extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'miniorange_samlsp_saml_config';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

}
