<?php

/**
 * @version     1.0.0
 * @package     mod_eiko_last
 * @copyright   Copyright (C) 2013 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <webmaster@feuerwehr-veenhusen.de> - http://einsatzkomponente.de
 */


defined('_JEXEC') or die;

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');

// Helper-class laden
require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; 


$title = $params->get('title');
$foto = $params->get('image');
$text = $params->get('content');
$mymenuitem = $params->get('mymenuitem'); // Menü-Eintrag

$orga = $params->get('orga');

if ($orga == '-- alle anzeigen --') :
		// Funktion : letze x Einsatzdaten laden
		$query = 'SELECT r.id,r.image as foto,rd.marker,r.address,r.summary,r.auswahlorga,r.desc,r.date1,r.data1,r.counter,r.alerting,r.presse,re.image,rd.list_icon,r.auswahlorga,r.state,rd.title as einsatzart FROM #__eiko_einsatzberichte r JOIN #__eiko_einsatzarten rd ON r.data1 = rd.title LEFT JOIN #__eiko_alarmierungsarten re ON re.id = r.alerting WHERE r.state = "1" and rd.state = "1" and re.state = "1" ORDER BY r.date1 DESC LIMIT '.$params->get('count').' ' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		$reports = $result;
else:
		// Funktion : letze x Einsatzdaten laden
		$query = 'SELECT r.id,r.image as foto,rd.marker,r.address,r.summary,r.auswahlorga,r.desc,r.date1,r.data1,r.counter,r.alerting,r.presse,re.image,rd.list_icon,r.auswahlorga,r.state,rd.title as einsatzart FROM #__eiko_einsatzberichte r JOIN #__eiko_einsatzarten rd ON r.data1 = rd.title LEFT JOIN #__eiko_alarmierungsarten re ON re.id = r.alerting WHERE FIND_IN_SET("'.$orga.'", r.auswahlorga) and r.state = "1" and rd.state = "1" and re.state = "1" ORDER BY r.date1 DESC LIMIT '.$params->get('count').' ' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		$reports = $result;
endif;

//echo $orga;

//$reports = EinsatzkomponenteHelper::letze_x_einsatzdaten ($params->get('count')); 
//print_r ($reports);break;



$counter = count($reports);


?>

<style type="text/css">

<?php echo $params->get('css');?>
</style>

<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
<<?php echo $params->get('module_tag');?> class="eiko_last<?php echo $moduleclass_sfx ?>" 
<?php else:?>
<div class="eiko_last<?php echo $moduleclass_sfx ?>" 
<?php endif; ?>

<?php if ($params->get('backgroundimage')) : ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >

<table border="1" class="eiko_last_div">

<?php
$a = 0;
while($a < $counter)
   {

$curTime = strtotime($reports[$a]->date1); 
$reports[$a]->desc = (strlen($reports[$a]->desc) > $params->get('char_desc','100')) ? substr($reports[$a]->desc,0,strrpos(substr($reports[$a]->desc,0,$params->get('char_desc','100')+1),' ')).' ...' : $reports[$a]->desc;
$reports[$a]->summary = (strlen($reports[$a]->summary) > $params->get('char_summary','30')) ? substr($reports[$a]->summary,0,strrpos(substr($reports[$a]->summary,0,$params->get('char_summary','30')+1),' ')).' ...' : $reports[$a]->summary;
   ?>
   
   
    <tr>
    	<th>
    	<?php if ($title=="einsatzort"):?><span class="eiko_last_address" ><?php echo $params->get('titel_zusatz').$reports[$a]->address;?></span>
	<?php endif;?>
    <?php if ($title=="kurzbericht"):?>
    <span class="eiko_last_summary" ><?php echo $params->get('titel_zusatz').$reports[$a]->summary;?></span>
	<?php endif;?>
    
    <?php if ($title=="einsatzart"):?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    <<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php echo '<span class="eiko_last_data" >'.$params->get('titel_zusatz').$reports[$a]->einsatzart.'</span>';?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    </<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php endif;?>
    <?php if ($title=="datum"):?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    <<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php echo '<span class="eiko_last_date" >'.$params->get('titel_zusatz').date('d.m.Y ', $curTime).'</span>';?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    </<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php endif;?>
    <?php if ($title=="datum_uhrzeit"):?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    <<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php echo '<span class="eiko_last_date" >'.$params->get('titel_zusatz').date('d.m.Y ', $curTime).'um '.date('H:i', $curTime).' Uhr</span>';?>
	<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
    </<?php echo $params->get('header_tag');?>>
	<?php endif;?>
	<?php endif;?>
	</th>
</tr>
<tr><td>
	<?php if ($foto=="1"):?>
    <?php if ($reports[$a]->foto):?>
    <?php if ($params->get('image_width')):?>
    <img class="eiko_last_image" src="<?php echo $reports[$a]->foto;?>" width="<?php echo $params->get('image_width');?>" alt="Einsatzfoto <?php echo $reports[$a]->summary;?>">
	<?php endif;?>
    <?php if ($params->get('!image_width')):?>
    <img class="eiko_last_image" src="<?php echo $reports[$a]->foto;?>" alt="Einsatzfoto <?php echo $reports[$a]->summary;?>">
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
    <?php if ($text=="einsatzort"):?>
    <span class="eiko_last_text"><?php echo $reports[$a]->address;?></span>
	<?php endif;?>
    <?php if ($text=="kurzbericht"):?>
    <span class="eiko_last_text"><?php echo $reports[$a]->summary;?></span>
	<?php endif;?>
    <?php if ($text=="einsatzart"):?>
    <span class="eiko_last_text"><?php echo $reports[$a]->einsatzart;?></span>
	<?php endif;?>
    <?php if ($text=="datum"):?>
    <span class="eiko_last_date"><?php echo date('d.m.Y ', $curTime);?></span>
	<?php endif;?>
    <?php if ($text=="datum_uhrzeit"):?>
    <span class="eiko_last_date"><?php echo date('d.m.Y ', $curTime).'um '.date('H:i', $curTime).' Uhr';?></span>
	<?php endif;?>
    <?php if ($text=="bericht"):?> 
    <span class="eiko_last_text"><?php echo strip_tags($reports[$a]->desc);?></span>
	<?php endif;?>
	
	
    	<br /><a class="eiko_last_readon_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_readon"><?php echo $params->get('readon');?></span></a></td>
    </tr>


    
   <?php
   $a++;
   }
?>
   </table>
<?php $version = new JVersion; if ($version->isCompatible('3.0')) :?>
</<?php echo $params->get('module_tag');?>>
<?php else:?>
</div>
<?php endif;?>
