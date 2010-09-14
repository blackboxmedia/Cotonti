<?php
/**
 * Administration panel - Referers manager
 *
 * @package Cotonti
 * @version 0.1.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2009
 * @license BSD
 */

(defined('SED_CODE') && defined('SED_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['auth_read']);

$t = new XTemplate(sed_skinfile('admin.referers'));

$adminpath[] = array(sed_url('admin', 'm=other'), $L['Other']);
$adminpath[] = array(sed_url('admin', 'm=referers'), $L['Referers']);
$adminhelp = $L['adm_help_referers'];

$d = sed_import('d', 'G', 'INT');
$d = empty($d) ? 0 : (int) $d;

/* === Hook  === */
foreach (sed_getextplugins('admin.referers.first') as $pl)
{
	include $pl;
}
/* ===== */

if($a == 'prune' && $usr['isadmin'])
{
	sed_sql_query("TRUNCATE $db_referers") ? sed_message('adm_ref_prune') : sed_message('Error');
}
elseif($a == 'prunelowhits' && $usr['isadmin'])
{
	sed_sql_delete($db_referers, 'ref_count < 6') ? sed_message('adm_ref_prunelowhits') : sed_message('Error');
}

$totalitems = sed_sql_rowcount($db_referers);
$pagenav = sed_pagenav('admin', 'm=referers', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql = sed_sql_query("SELECT * FROM $db_referers ORDER BY ref_count DESC LIMIT $d, ".$cfg['maxrowsperpage']);

if(sed_sql_numrows($sql) > 0)
{
	while($row = sed_sql_fetcharray($sql))
	{
		preg_match("#//([^/]+)/#", $row['ref_url'], $a);
		$host = preg_replace('#^www\.#i', '', $a[1]);
		$referers[$host][$row['ref_url']] = $row['ref_count'];
	}

	$ii = 0;
	/* === Hook - Part1 : Set === */
	$extp = sed_getextplugins('admin.referers.loop');
	/* ===== */
	foreach($referers as $referer => $url)
	{

		$t->assign('ADMIN_REFERERS_REFERER', htmlspecialchars($referer));
		
		foreach($url as $uri => $count)
		{
			$t->assign(array(
				'ADMIN_REFERERS_URI' => htmlspecialchars(sed_cutstring($uri, 128)),
				'ADMIN_REFERERS_COUNT' => $count,
				'ADMIN_REFERERS_ODDEVEN' => sed_build_oddeven($ii)
			));
			/* === Hook - Part2 : Include === */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */
			$t->parse('MAIN.REFERERS_ROW.REFERERS_URI');
		}
		$t->parse("MAIN.REFERERS_ROW");
		$ii++;
	}
	$is_ref_empty = true;
}
else
{
	$is_ref_empty = false;
}

$t->assign(array(
	'ADMIN_REFERERS_URL_PRUNE' => sed_url('admin', 'm=referers&a=prune&'.sed_xg()),
	'ADMIN_REFERERS_URL_PRUNELOWHITS' => sed_url('admin', 'm=referers&a=prunelowhits&'.sed_xg()),
	'ADMIN_REFERERS_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_REFERERS_PAGNAV' => $pagenav['main'],
	'ADMIN_REFERERS_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_REFERERS_TOTALITEMS' => $totalitems,
	'ADMIN_REFERERS_ON_PAGE' => $ii
));

sed_display_messages($t);

/* === Hook  === */
foreach (sed_getextplugins('admin.referers.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
if (SED_AJAX)
{
	$t->out('MAIN');
}
else
{
	$adminmain = $t->text('MAIN');
}

?>