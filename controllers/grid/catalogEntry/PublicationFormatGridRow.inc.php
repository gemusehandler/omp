<?php

/**
 * @file controllers/grid/catalogEntry/PublicationFormatGridRow.inc.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PublicationFormatGridRow
 * @ingroup controllers_grid_catalogEntry
 *
 * @brief Handle publication format grid row requests.
 */

import('lib.pkp.controllers.grid.files.SubmissionFilesGridRow');
import('lib.pkp.classes.controllers.grid.files.FilesGridCapabilities');

class PublicationFormatGridRow extends SubmissionFilesGridRow {

	/**
	 * Constructor
	 * @param $capabilities FilesGridCapabilities
	 * @param $stageId int Stage ID (optional)
	 */
	function PublicationFormatGridRow() {
		parent::SubmissionFilesGridRow(
			new FilesGridCapabilities(FILE_GRID_ADD | FILE_GRID_DELETE | FILE_GRID_MANAGE | FILE_GRID_EDIT | FILE_GRID_VIEW_NOTES),
			WORKFLOW_STAGE_ID_PRODUCTION
		);
	}


	//
	// Overridden template methods from GridRow
	//
	/**
	 * @copydoc PKPHandler::initialize()
	 */
	function initialize($request, $template = 'controllers/grid/gridRow.tpl') {
		parent::initialize($request, $template);
		$submissionFileData =& $this->getData();
		$submissionFile =& $submissionFileData['submissionFile']; /* @var $submissionFile SubmissionFile */
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$router = $request->getRouter();
		if ($submissionFile->getFileType() == 'text/html') $this->addAction(new LinkAction(
			'dependentFiles',
			new AjaxModal(
				$router->url($request, null, null, 'dependentFiles', null, array_merge(
					$this->getRequestArgs(),
					array(
						'fileId' => $submissionFile->getFileId(),
						'revision' => $submissionFile->getRevision(),
					)
				)),
				__('submission.dependentFiles'),
				'modal_edit'
			),
			__('submission.dependentFiles'),
			'edit'
		));
	}
}

?>