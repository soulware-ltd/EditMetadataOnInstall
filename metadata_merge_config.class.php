<?php
namespace Soulware;

class metadataMergeConfig {
    public $module; //string
    public $sourcefile; //string
    public $type; //string
    public $variable_name; //string
    public $content; //array struct


    function __construct($module, $sourcefile, $type, $variable_name, $content) {
        $this->module = $module;
        $this->sourcefile = $sourcefile;
        $this->type = $type;
        $this->variable_name = $variable_name;
        $this->content = $content;
    }

    
   /* $merge_config[] = array(
	'module' => 'Project',
	'sourcefile' => 'detailviewdefs.php',
	'type' => 'metadata',
	'variable_name' => 'viewdefs',
	'content' => array("Project" => 
					array("DetailView" => 
							array("panels" => 
									array("lbl_project_information" => 
										array( 
											array(
												0 => 'field_name',
												1 => array('name' => 'nameee', 'rname' => 'LBL_AKARMI'),
											), 
										)
									)
							)
					)
				),
);

$merge_config[] = array(
	'module' => 'Project',
	'sourcefile' => 'default.php',
	'type' => 'metadata/subpanels',
	'variable_name' => 'subpanel_layout',
	'content' => array('top_buttons' => array(
		array('widget_class2' => 'SubPanelTopSelectButton2', 'popup_module2' => 'Accounts2'),
			),),
);*/

}
