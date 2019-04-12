<?php 

namespace HelsingborgStad;

use BC\Blade\Blade as BladeInstance;

class GlobalBladeEngine {

    /**
     * Gets previous instance, or create a new if empty/invalid 
     * 
     * @return object The blade obect 
     */
    public static function instance() {

        //Get global
        global $globalBladeEngineInstance; 

        //Check if a instance has been created
        if(!is_a($globalBladeEngineInstance, 'BC\Blade\Blade')) {

            //Require view paths
            if(empty(self::getViewPaths())) {
                throw new \Exception("Error: View paths must be defined before running init.");
            }

            //Create new blade instance
            $globalBladeEngineInstance = new BladeInstance(
                (array) self::getViewPaths(),
                (string) sys_get_temp_dir() . '/global-blade-engine-cache/'
            );

            //Check for newly created instance
            if(!is_a($globalBladeEngineInstance, 'BC\Blade\Blade')) {
                //Error if something went wrong
                throw new \Exception("Error: Could not create new instance of blade compiler class.");
            }
        }

        return $globalBladeEngineInstance; 
    }

    /**
     * Appends/prepends the view path object 
     * 
     * @return string The updated object with controller paths
     */
    public static function addViewPath($path, $prepend = true) : array 
    {
        //Get global
        global $globalBladeEngineInstanceViewPaths; 

        //Make array if undefined
        if(!is_array($globalBladeEngineInstanceViewPaths)) {
            $globalBladeEngineInstanceViewPaths = array(); 
        }

        //Sanitize path
        $path = rtrim($path, "/");

        //Push to location array
        if($prepend === true) {
            if (array_unshift($globalBladeEngineInstanceViewPaths, $path)) {
                return $globalBladeEngineInstanceViewPaths;
            }
        } else {
            if (array_push($globalBladeEngineInstanceViewPaths, $path)) {
                return $globalBladeEngineInstanceViewPaths;
            }
        }
        
        //Error if something went wrong
        throw new \Exception("Error appending controller path: " . $path);
    }

    /**
     * Gets the view paths as array 
     * 
     * @return string The updated object with controller paths
     */
    public static function getViewPaths() : array 
    {
        //Get global
        global $globalBladeEngineInstanceViewPaths; 

        //return global
        if(is_array($globalBladeEngineInstanceViewPaths)) {
            return $globalBladeEngineInstanceViewPaths; 
        }
        
        //Error if something went wrong
        throw new \Exception("Error getting view paths " . $path);
    }

}