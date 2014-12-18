<?php

namespace Soulware\EditMetadataOnInstall;

class metadataMerge {

    protected $merge_configs;
    
    
    public function setMergeConfig($merge_configs){
        $this->merge_configs=$merge_configs;
    }
    
    public function install() {

        $console_messages = true;

        //require_once(__DIR__ . '/metadata_merge.config.php');
            
        if (isset($this->merge_configs) && is_array($this->merge_configs)) {

            if ($console_messages)
                echo "metadata info found.<br />--------------------------<br />";
                //print_r($this->merge_configs);
            foreach ($this->merge_configs as $file_info) {
               // print_r($file_info);
                $source_path = $this->metadata_getSourceFilePath($file_info->module, $file_info->type, $file_info->sourcefile);
                if ($source_path) {

                    if (!include($source_path)) {
                        if ($console_messages)
                            echo "opening " . $source_path . " faliled<br />";
                    }
                    else { 
                        if ($console_messages)
                            echo "opening " . $source_path . " succeeded<br />";
                    }

                    $varname = $file_info->variable_name;

                    $paths = $this->metadata_getPaths($file_info->module, $file_info->type, $file_info->sourcefile);

                    if ($console_messages)
                        echo "merging content with $$varname<br />";

                    $return_array = array_merge_recursive($$varname, $file_info->content);

                    $string = "<?php\n";
                    $string .= "$$varname = ";
                    $string .= var_export($return_array, true);
                    $string .= "\n?>";

                    $this->metadata_createDirStructure($paths['custom_path']);

                    file_put_contents($paths['custom_path'], $string);

                    if ($console_messages)
                        echo ":)<br />";
                }
                else {

                    if ($console_messages)
                        echo "no sourcefile found.<br />";
                }
            }
        }
        else {

            if ($console_messages)
                echo "no merge config data found.\n";
        }
    }

    public function uninstall() {
        $console_messages = true;

        require_once(__DIR__ . '/metadata_merge.config.php');

        if (isset($this->merge_configs) && is_array($this->merge_configs)) {

            if ($console_messages)
                echo "metadata info found.<br />--------------------------<br />";

            foreach ($this->merge_configs as $file_info) {

                if ($source_path = $this->metadata_getSourceFilePath($file_info->module, $file_info->type, $file_info->sourcefile)) {

                    if (!include($source_path)) {
                        if ($console_messages)
                            echo "opening " . $source_path . " faliled<br />";
                    }
                    else {
                        if ($console_messages)
                            echo "opening " . $source_path . " succeeded<br />";
                    }

                    $varname = $file_info->variable_name;
                
                    $paths = $this->metadata_getPaths($file_info->module, $file_info->type, $file_info->sourcefile);
                  
                    if ($console_messages)
                        echo "merging content with $$varname<br />";
                    // Unset does not work
                   $this->unSetMetadata($file_info);                  
               
                    $string = "<?php\n";
                    $string .= "$$varname = ";
                    $string .= "\n?>";
                 
                    $this->metadata_createDirStructure($paths['custom_path']);

                    file_put_contents($paths['custom_path'], $string);

                    if ($console_messages)
                        echo ":)<br />";
                }
                else {

                    if ($console_messages)
                        echo "no sourcefile found.<br />";
                }
            }
        }
        else {

            if ($console_messages)
                echo "no merge config data found.\n";
        }
    }
    
    public function unSetMetadata($file_info){
        foreach ($$file_info as $data){
            
        }    
    }

    public function metadata_getSourceFilePath($module, $type, $filename) {

        $paths = $this->metadata_getPaths($module, $type, $filename);

        if (is_file($paths['custom_path'])) {
            return $paths['custom_path'];
        } elseif (is_file($paths['path'])) {
            return $paths['path'];
        } else {
            return false;
        }
    }

    public function metadata_getPaths($module, $type, $filename) {

        $path = 'modules/' . $module . '/' . $type . '/' . $filename;
        $custom_path = 'custom/' . $path;

        return array('path' => $path, 'custom_path' => $custom_path);
    }

    public function metadata_createDirStructure($path) {

        $current_path = "";

        $dir_array = $this->metadata_getDirArray($path);

        foreach ($dir_array as $dir) {

            $current_path .= $dir . "/";

            if (!is_dir($current_path)) {

                mkdir($current_path);
            }
        }

        return true;
    }

    public function metadata_getDirArray($path) {

        $return_array = explode('/', $path);
        array_pop($return_array);

        return $return_array;
    }

}
