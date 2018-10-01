<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session{

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Update an existing session
     *
     * @access    public
     * @return    void
    */
    function sess_update()
    {
       // skip the session update if this is an AJAX call!
       if ( ! IS_AJAX )
       {
           parent::sess_update();
       }
    }
    
    // --------------------------------------------------------------------

    /**
     * Serialize an array
     *
     * This function first converts any slashes found in the array to a temporary
     * marker, so when it gets unserialized the slashes will be preserved
     *
     * @access    private
     * @param    array
     * @return    string
     */
    function _serialize($data)
    {
        if (is_array($data))
        {
            foreach ($data as $key => $val)
            {
                if (is_string($val))
                {
                    $data[$key] = str_replace('\\', '{{slash}}', $val);
                }
            }
        }
        else
        {
            if (is_string($data))
            {
                $data = str_replace('\\', '{{slash}}', $data);
            }
        }

        return base64_encode(serialize($data));
    }

    // --------------------------------------------------------------------

    /**
     * Unserialize
     *
     * This function unserializes a data string, then converts any
     * temporary slash markers back to actual slashes
     *
     * @access    private
     * @param    array
     * @return    string
     */
    function _unserialize($data)
    {
        $data = base64_decode($data);
        $data = @unserialize(strip_slashes($data));

        if (is_array($data))
        {
            foreach ($data as $key => $val)
            {
                if (is_string($val))
                {
                    $data[$key] = str_replace('{{slash}}', '\\', $val);
                }
            }

            return $data;
        }

        return (is_string($data)) ? str_replace('{{slash}}', '\\', $data) : $data;
    }     

} 