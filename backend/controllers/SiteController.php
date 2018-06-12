<?php
namespace backend\controllers;

use backend\models\Users;
use common\models\Access;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'users'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!in_array($action->id,['login', 'error'])) {
            if (!Access::isAdmin())
                $this->redirect('login');
                //throw new ForbiddenHttpException('Доступ к этому разделу запрещен!');
        }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUsers($m='')
    {
        switch($m)
        {
            case 'add':
                return $this->UsersAdd();

        }

        return $this->UsersIndex();
    }

    private function UsersIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
            'sort' => [ // сортировка по умолчанию
                'defaultOrder' => ['username' => SORT_DESC],
            ],
            'pagination' => [ // постраничная разбивка
                'pageSize' => 10, // 10 новостей на странице
            ],
        ]);
        return $this->render('users',['data'=>$dataProvider]);
    }

    private function UsersAdd()
    {
        $model=new Users();
        return $this->render('usersForm',['model'=>$model]);
    }
}
