<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public $errors;
	protected $table = 'users';
	protected $fillable = array('user','email', 'full_name', 'password','fullname','address','rank');
	protected $primaryKey = 'id_user';
	protected $perPage = 2;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function isValid($data)
    {
        $rules = array(
        	'user'  => 'required|min:4|max:15|unique:users',
	        'password'  => 'min:7|confirmed',
	        'email'     => 'required|email|unique:users,email',
	        'fullname' => 'required|min:4|max:40',
	        'address'  => 'required|min:8',
	        'rank'  => 'required'
        );

        // Si el usuario existe:
        if ($this->exists)
        {
          //Evitamos que la regla “unique” tome en cuenta el email del usuario actual
					$rules['email'] .= ',' . $this->id_user . ',id_user';
        }
        else // Si no existe...
        {
            // La clave es obligatoria:
            $rules['password'] .= '|required';
        }
         $validator = Validator::make($data, $rules);
        
        if ($validator->passes())
         {
             return true;
         }
        
        $this->errors = $validator->errors();
        
        return false;
    }

  public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

}


