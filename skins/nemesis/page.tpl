<!-- BEGIN: MAIN -->

		<div id="center" class="column">
			<div class="block">
				<h2 class="page">{PAGE_TITLE}</h2>
					<div class="combox">{PHP.pag.page_comcount}</div>
					<h3>{PAGE_SHORTTITLE}</h3>
					<!-- IF {PAGE_DESC} --><p class="small">{PAGE_DESC}</p><!-- ENDIF -->

					<div class="clear desc">
						<p class="column">
						<strong>{PHP.L.Tags}:</strong>
						<!-- BEGIN: PAGE_TAGS_ROW -->
							<!-- IF {PHP.tag_i} > 0 -->,
							<!-- ENDIF -->
							<a href="{PAGE_TAGS_ROW_URL}">{PAGE_TAGS_ROW_TAG}</a>
						<!-- END: PAGE_TAGS_ROW -->
						<!-- BEGIN: PAGE_NO_TAGS -->
							{PAGE_NO_TAGS}
						<!-- END: PAGE_NO_TAGS -->
						</p>
						<p class="column floatright">
							<strong>Filed under:</strong>{PAGE_CATPATH}
						</p>
					</div>

					<div class="textbox">{PAGE_TEXT}</div>
					<!-- BEGIN: PAGE_FILE -->
						<div class="download">
							<!-- BEGIN: MEMBERSONLY -->
							{PAGE_SHORTTITLE}<br/>
							<!-- END: MEMBERSONLY -->
							<!-- BEGIN: DOWNLOAD -->
							<p>{PHP.L.Download}: <a class="strong" href="{PAGE_FILE_URL}">{PAGE_SHORTTITLE}</a></p>
							<!-- END: DOWNLOAD -->
						{PHP.skinlang.page.Filesize}: {PAGE_FILE_SIZE}{PHP.L.kb}<br />
						{PHP.skinlang.page.downloaded}: {PAGE_FILE_COUNT} {PHP.skinlang.page.times}
						</div>
					<!-- END: PAGE_FILE -->
			</div>
			{PAGE_COMMENTS_DISPLAY}
		</div>

		<div id="side" class="column">
			<!-- BEGIN: PAGE_ADMIN -->
{FILE "skins/nemesis/inc/admin-page.tpl"}
			<!-- END: PAGE_ADMIN -->
{FILE "skins/nemesis/inc/contact.tpl"}
			<!-- BEGIN: PAGE_MULTI -->
			<div class="block">
				<h2 class="info">{PHP.skinlang.page.Summary}:</h2>
				{PAGE_MULTI_TABTITLES}
				<p class="paging">{PAGE_MULTI_TABNAV}</p>
			</div>
			<!-- END: PAGE_MULTI -->
		</div>

<!-- END: MAIN -->