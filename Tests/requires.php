<?php
	require_once '../../config.php';

	require_once '../config.php';

	require_once BASE_PATH_FOR_TESTS . 'BaseClass.php';

	require_once BASE_PATH_FOR_TESTS . 'Models/BaseModel.php';

	require_once BASE_PATH_FOR_TESTS . 'Models/Interfaces/Cookie.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Interfaces/Database.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Interfaces/Http.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Interfaces/Session.php';

	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/Author.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/Book.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/Cart.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/Genre.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/Order.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Performers/User.php';

	require_once BASE_PATH_FOR_TESTS . 'Models/Utilities/ObjFactory.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Utilities/DataContainer.php';

	require_once BASE_PATH_FOR_TESTS . 'Models/Validators/ValidatorLogin.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Validators/ValidatorSignup.php';
	require_once BASE_PATH_FOR_TESTS . 'Models/Validators/ValidatorUser.php';