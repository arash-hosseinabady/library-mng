<?php

namespace app\controllers;

use app\models\Book;
use app\models\LoginForm;
use app\models\User;
use yii\rest\Controller;
use sizeg\jwt\JwtHttpBearerAuth;
use sizeg\jwt\Jwt;
use Yii;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        $modelLogin = new LoginForm();

        if (Yii::$app->request->post()) {
            if (!Yii::$app->request->post('username') || !Yii::$app->request->post('password')) {
                $response = [
                    'status' => false,
                    'message' => Yii::t('app', 'Send both username and password!')
                ];
            } else {
                $modelLogin->username = Yii::$app->request->post('username');
                $modelLogin->password = Yii::$app->request->post('password');
                if ($modelLogin->login()) {
                    $token = $jwt->getBuilder()
                        ->issuedBy('http://library-mng.com')
                        ->permittedFor('http://library-mng.org')
                        ->identifiedBy('1q2w3e4r5t', true)
                        ->issuedAt($time)
                        ->expiresAt($time + 3600)
                        ->withClaim('uid', $modelLogin->getUser()->id)
                        ->getToken($signer, $key);

                    $response = [
                        'status' => true,
                        'message' => Yii::t('app', 'Login success'),
                        'token' => (string)$token,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => Yii::t('app', 'Invalid username or password!')
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'message' => Yii::t('app', 'Invalid request!')
            ];
        }

        return $this->asJson([
            $response
        ]);
    }

    /**
     * @param null $id
     * @return \yii\web\Response
     */
    public function actionBook($id = null)
    {
        if (User::hasRole('superadmin')) {
            $where = true;
        } else {
            $where = ['writer_id' => User::$user->writer->id];
        }
        $bookModel = new Book();
        switch ($request = Yii::$app->request) {
            case $request->isGet:
                if ($id) {
                    $books = $bookModel::find()
                        ->where([
                            'id' => $id,
                        ])
                        ->andWhere($where)
                        ->asArray()
                        ->all();
                } else {
                    $books = $bookModel::find()
                        ->asArray()
                        ->where($where)
                        ->all();
                }
                return $this->asJson([
                    'status' => true,
                    'data' => $books
                ]);
                break;
            case $request->isPost:
                if (!Yii::$app->request->post('name') || !Yii::$app->request->post('desc')) {
                    $response = [
                        'status' => false,
                        'message' => Yii::t('app', 'Send both name and description of book!')
                    ];
                } else {
                    $bookModel->name = Yii::$app->request->post('name');
                    $bookModel->desc = Yii::$app->request->post('desc');
                    if (isset(User::$user->writer->id)) {
                        $bookModel->writer_id = User::$user->writer->id;
                        if ($bookModel->save()) {
                            $response = [
                                'status' => true,
                                'message' => Yii::t('app', 'Insert book is success.')
                            ];
                        } else {
                            $response = [
                                'status' => false,
                                'message' => Yii::t('app', 'Error in inserted book!')
                            ];
                        }
                    } else {
                        $response = [
                            'status' => false,
                            'message' => Yii::t('app', 'You not allow to create book!')
                        ];
                    }
                }

                return $this->asJson([
                    $response
                ]);
                break;
            case $request->isDelete:
                if (!$id) {
                    $response = [
                        'status' => false,
                        'message' => Yii::t('app', 'Invalid request!')
                    ];
                } else {
                    if (isset(User::$user->writer->id)) {
                        $book = $bookModel::findOne([
                            'id' => $id,
                            'writer_id' => User::$user->writer->id,
                        ]);
                        if ($book) {
                            if ($bookModel::deleteAll(['id' => $id])) {
                                $response = [
                                    'status' => true,
                                    'message' => Yii::t('app', 'The book \'' . $book->name . '\' is deleted.')
                                ];
                            } else {
                                $response = [
                                    'status' => false,
                                    'message' => Yii::t('app', 'Error in deleting!')
                                ];
                            }
                        } else {
                            $response = [
                                'status' => false,
                                'message' => Yii::t('app', 'Invalid request!')
                            ];
                        }
                    } else {
                        $response = [
                            'status' => false,
                            'message' => Yii::t('app', 'You not allow to delete book!')
                        ];
                    }
                }

                return $this->asJson([
                    $response
                ]);
                break;
            case $request->isPatch:
            case $request->isPut:
                if (!$id) {
                    $response = [
                        'status' => false,
                        'message' => Yii::t('app', 'Invalid request!')
                    ];
                } else {
                    if (isset(User::$user->writer->id)) {
                        $book = $bookModel::findOne([
                            'id' => $id,
                            'writer_id' => User::$user->writer->id,
                        ]);
                        if ($book) {
                            if (($name = $this->PUT('name')) != false) {
                                $book->name = $name;
                            }
                            if (($desc = $this->PUT('desc')) != false) {
                                $book->desc = $desc;
                            }

                            if ($book->save()) {
                                $response = [
                                    'status' => true,
                                    'message' => Yii::t('app', 'The book is updated.')
                                ];
                            } else {
                                $response = [
                                    'status' => false,
                                    'message' => Yii::t('app', 'Error in updating!')
                                ];
                            }
                        } else {
                            $response = [
                                'status' => false,
                                'message' => Yii::t('app', 'Invalid request!')
                            ];
                        }
                    } else {
                        $response = [
                            'status' => false,
                            'message' => Yii::t('app', 'You not allow to update book!')
                        ];
                    }
                }
                return $this->asJson([
                    $response
                ]);
                break;
            default:
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t('app', 'Invalid request!')
                ]);
                break;
        }
    }

    function PUT($key){
        $inputFileSrc = 'php://input';
        $lines = file($inputFileSrc);

        foreach($lines as $i =>  $line){
            $search = 'Content-Disposition: form-data; name="'.$key.'"';
            if(strpos($line, $search) !== false){
                return trim($lines[$i+2]);
            }
        }

        return false;
    }
}