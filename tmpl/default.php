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

if ($orga == '0') :
		// Funktion : letze x Einsatzdaten laden
		$query = 'SELECT r.id,r.image as foto,rd.marker,r.address,r.summary,r.auswahl_orga,r.desc,r.date1,r.data1,r.counter,r.alerting,r.presse,re.image,rd.list_icon,r.state,rd.title as einsatzart FROM #__eiko_einsatzberichte r JOIN #__eiko_einsatzarten rd ON r.data1 = rd.id LEFT JOIN #__eiko_alarmierungsarten re ON re.id = r.alerting WHERE r.state = "1" and rd.state = "1" and re.state = "1" ORDER BY r.date1 DESC LIMIT '.$params->get('count').' ' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		$reports = $result;
else:
		// Funktion : letze x Einsatzdaten laden
		$query = 'SELECT r.id,r.image as foto,rd.marker,r.address,r.summary,r.auswahl_orga,r.desc,r.date1,r.data1,r.counter,r.alerting,r.presse,re.image,rd.list_icon,r.state,rd.title as einsatzart FROM #__eiko_einsatzberichte r JOIN #__eiko_einsatzarten rd ON r.data1 = rd.id LEFT JOIN #__eiko_alarmierungsarten re ON re.id = r.alerting WHERE FIND_IN_SET("'.$orga.'", r.auswahl_orga) and r.state = "1" and rd.state = "1" and re.state = "1" ORDER BY r.date1 DESC LIMIT '.$params->get('count').' ' ;
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

<?php echo $params->get('eiko_last_css');?>
</style>

<<?php echo $params->get('module_tag');?> class="eiko_last<?php echo $moduleclass_sfx ?>" 
<?php if ($params->get('backgroundimage')) : ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >

<table class="eiko_last_table">
<tr><td>
<?php
$a = 0;
while($a < $counter)
   {

$curTime = strtotime($reports[$a]->date1); 
$reports[$a]->desc = (strlen($reports[$a]->desc) > $params->get('char_desc','100')) ? substr($reports[$a]->desc,0,strrpos(substr($reports[$a]->desc,0,$params->get('char_desc','100')+1),' ')).' ...' : $reports[$a]->desc;
$reports[$a]->summary = (strlen($reports[$a]->summary) > $params->get('char_summary','30')) ? substr($reports[$a]->summary,0,strrpos(substr($reports[$a]->summary,0,$params->get('char_summary','30')+1),' ')).' ...' : $reports[$a]->summary;

$fields = str_replace(' ','',$params->get('fields'));
$fields = explode(",",$fields);

?>
<table class="eiko_last_tab">
<?php
$count_fields = count($fields);
$i = 0;
while($i < $count_fields)
   { 
    	if (trim($fields[$i])=="Kurzbericht_Link"):?><tr class="eiko_last_kurzbericht_tr"><td class="eiko_last_kurzbericht_td"><a class="eiko_last_kurzbericht_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span  class="eiko_last_kurzbericht_span"><?php $reports[$a]->summary;?></span></a></td></tr><?php endif;
		
    	if (trim($fields[$i])=="Einsatzort"):?><tr class="eiko_last_einsatzort_tr"><td class="eiko_last_einsatzort_td"><span  class="eiko_last_einsatzort_span"><?php echo $params->get('einsatzort_zusatz').$reports[$a]->address;?></span></td></tr><?php endif;
    	if (trim($fields[$i])=="Einsatzort_Link"):?><tr class="eiko_last_einsatzort_tr"><td class="eiko_last_einsatzort_td"><a class="eiko_last_einsatzort_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span  class="eiko_last_einsatzort_span"><?php echo $params->get('einsatzort_zusatz').$reports[$a]->address;?></span></a></td></tr><?php endif;
		
    	if (trim($fields[$i])=="Einsatzart"):?><tr class="eiko_last_einsatzart_tr"><td class="eiko_last_einsatzart_td"><span class="eiko_last_einsatzart_span"><?php echo $reports[$a]->einsatzart;?></span></td></tr><?php endif;
    	if (trim($fields[$i])=="Einsatzart_Link"):?><tr class="eiko_last_einsatzart_tr"><td class="eiko_last_einsatzart_td"><a class="eiko_last_einsatzart_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_einsatzart_span"><?php echo $reports[$a]->einsatzart;?></span></a></td></tr><?php endif;
		
		if (trim($fields[$i])=="Kurzbericht"):?><tr class="eiko_last_kurzbericht_tr"><td class="eiko_last_kurzbericht_td"><span class="eiko_last_kurzbericht_span"><?php echo $reports[$a]->summary;?></span></td></tr><?php endif;
		
		if (trim($fields[$i])=="Datum"):?><tr class="eiko_last_datum_tr"><td class="eiko_last_datum_td"><span class="eiko_last_datum_span"><?php echo date('d.m.Y ', $curTime);?></span></td></tr><?php endif;
		if (trim($fields[$i])=="Datum_Link"):?><tr class="eiko_last_datum_tr"><td class="eiko_last_datum_td"><a class="eiko_last_datum_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_datum_span"><?php echo date('d.m.Y ', $curTime);?></span></a></td></tr><?php endif;

		if (trim($fields[$i])=="Datum_Uhrzeit"):?><tr class="eiko_last_datum_uhrzeit_tr"><td class="eiko_last_datum_uhrzeit_td"><span class="eiko_last_datum_uhrzeit_span"><?php echo date('d.m.Y ', $curTime).'um '.date('H:i', $curTime).' Uhr';?></span></td></tr><?php endif;
		if (trim($fields[$i])=="Datum_Uhrzeit_Link"):?><tr class="eiko_last_datum_uhrzeit_tr"><td class="eiko_last_datum_uhrzeit_td"><a class="eiko_last_datum_uhrzeit_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_datum_uhrzeit_span"><?php echo date('d.m.Y ', $curTime).'um '.date('H:i', $curTime).' Uhr';?></span></a></td></tr><?php endif;
		

		if (trim($fields[$i])=="Einsatzfoto"): if ($reports[$a]->foto): ?><tr class="eiko_last_image_tr"><td class="eiko_last_image_td"><img class="eiko_last_image" src="<?php echo $reports[$a]->foto;?>" width="100%" alt="Einsatzfoto <?php echo $reports[$a]->summary;?>"></td></tr><?php endif;?><?php endif;
		if (trim($fields[$i])=="Einsatzfoto_Link"): if ($reports[$a]->foto): ?><tr class="eiko_last_image_tr"><td class="eiko_last_image_td"><a class="eiko_last_image_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><img class="eiko_last_image" src="<?php echo $reports[$a]->foto;?>" width="100%" alt="Einsatzfoto <?php echo $reports[$a]->summary;?>"></a></td></tr><?php endif;?><?php endif;

		if (trim($fields[$i])=="Datum_Einsatzart"):?><tr class="eiko_last_datum_einsatzart_tr"><td class="eiko_last_datum_einsatzart_td"><span class="eiko_last_datum_einsatzart_span"><?php echo date('d.m.Y ', $curTime);?> - <?php echo $reports[$a]->einsatzart;?></span></td></tr><?php endif;
		if (trim($fields[$i])=="Datum_Einsatzart_Link"):?><tr class="eiko_last_datum_einsatzart_tr"><td class="eiko_last_datum_einsatzart_td"><a class="eiko_last_datum_einsatzart_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_datum_einsatzart_span"><?php echo date('d.m.Y ', $curTime);?> - <?php echo $reports[$a]->einsatzart;?></span></a></td></tr><?php endif;
		
		if (trim($fields[$i])=="Datum_Einsatzort"):?><tr class="eiko_last_datum_einsatzort_tr"><td class="eiko_last_datum_einsatzort_td"><span class="eiko_last_datum_einsatzort_span"><?php echo date('d.m.Y ', $curTime);?> - <?php echo $reports[$a]->address;?></span></td></tr><?php endif;
		if (trim($fields[$i])=="Datum_Einsatzort_Link"):?><tr class="eiko_last_datum_einsatzort_tr"><td class="eiko_last_datum_einsatzort_td"><a class="eiko_last_datum_einsatzort_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_datum_einsatzort_span"><?php echo date('d.m.Y ', $curTime);?> - <?php echo $reports[$a]->address;?></span></a></td></tr><?php endif;

		if (trim($fields[$i])=="Datum_Uhrzeit_Kurzbericht"):?><tr class="eiko_last_datum_uhrzeit_kurzbericht_tr"><td class="eiko_last_datum_uhrzeit_kurzbericht_td"><span class="eiko_last_datum_uhrzeit_kurzbericht_span"><?php echo date('d.m.Y ', $curTime);?> um <?php echo date('H:i', $curTime);?> Uhr <b><?php echo $reports[$a]->summary;?></b></span></td></tr><?php endif;
		if (trim($fields[$i])=="Datum_Uhrzeit_Kurzbericht_Link"):?><tr class="eiko_last_datum_uhrzeit_kurzbericht_tr"><td class="eiko_last_datum_uhrzeit_kurzbericht_td"><span class="eiko_last_datum_uhrzeit_kurzbericht_span"><?php echo date('d.m.Y ', $curTime);?> um <?php echo date('H:i', $curTime);?> Uhr <a class="eiko_last_datum_einsatzort_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><b><?php echo $reports[$a]->summary;?></b></a></span></td></tr><?php endif;
		
		if (trim($fields[$i])=="Datum_Uhrzeit_Einsatzart_Einsatzort_Weiterlesen"):?><tr class="eiko_last_datum_uhrzeit_einsatzart_einsatzort_weiterlesen_tr"><td class="eiko_last_datum_uhrzeit_einsatzart_einsatzort_weiterlesen_td"><span class="eiko_last_datum_uhrzeit_einsatzart_einsatzort_weiterlesen_span"><?php echo date('d.m.Y ', $curTime).' um '.date('H:i', $curTime).' Uhr <b>'.$reports[$a]->einsatzart.'</b> '.$reports[$a]->address.'<a class="eiko_last_weiterlesen_link" href="'.JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id).'"><span class="eiko_last_weiterlesen_span">'.$params->get('readon').'</span></a></span></td></tr>';?><?php endif;
	
		if (trim($fields[$i])=="Datum_Einsatzart_Kurzbericht"):?><tr class="eiko_last_datum_einsatzart_kurzbericht_tr"><td class="eiko_last_datum_einsatzart_kurzbericht_td"><span class="eiko_last_uhrzeit_einsatzart_kurzbericht_span"><?php echo date('d.m.Y ', $curTime).' <b><a class="eiko_last_einsatzart_link" href="'.JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id).'">'.$reports[$a]->einsatzart.'</a></b> '.$reports[$a]->summary.'</span></td></tr>';?><?php endif;

		if (trim($fields[$i])=="Weiterlesen"):?><tr class="eiko_last_weiterlesen_tr"><td class="eiko_last_weiterlesen_td"><a class="eiko_last_weiterlesen_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&Itemid='.$mymenuitem.'&view=einsatzbericht&id=' . (int)$reports[$a]->id); ?>"><span class="eiko_last_weiterlesen_span"><?php echo $params->get('readon');?></span></a></td></tr><?php endif;

		//echo $fields[$i].'<br/>';
$i++;
   }
//$bodytag = str_replace("%body%", "schwarz", "<body text='%body%'>");

?>
</table>


   

    
   <?php
   $a++;
   }
?>
   </td></tr></table>
</<?php echo $params->get('module_tag');?>>
