<?php require_once("$_SERVER[DOCUMENT_ROOT]/../db/common.dal.inc.php");

function DBFetchRole() {
	return _DBFetchQuery(
		"SELECT * FROM Roles"
	);
}
