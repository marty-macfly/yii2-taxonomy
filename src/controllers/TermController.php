<?php

namespace macfly\taxonomy\controllers;

use Yii;
use macfly\taxonomy\models\Term;
use macfly\taxonomy\models\Taxonomy;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * TermController implements the CRUD actions for Term model.
 */
class TermController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [],
                ],
            ],
        ];
    }

    /**
     * Lists all Term models.
     * @return mixed
     */
    public function actionIndex()
    {
        $terms = Term::find()->all();
        return $this->render('index', [
            'terms' => $terms,
        ]);
    }

    /**
     * Displays a single Term model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Term model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Term();
        $taxonomies = Taxonomy::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->usage_count=0;
            $this->storeTerm($model);
        } else {
            return $this->render('create', [
                'model' => $model,'taxonomies'=>$taxonomies
            ]);
        }
    }

    /**
     * Updates an existing Term model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $taxonomies = Taxonomy::find()->all();
        if ($model->load(Yii::$app->request->post())) {
          $this->storeTerm($model);
        }
        else {
            return $this->render('update', [
                'model' => $model,'taxonomies'=>$taxonomies
            ]);
        }
    }

    private function storeTerm($model)
    {
      $tag_type = Yii::$app->request->post('Taxonomy_type',null);
      $tag_name = Yii::$app->request->post('Taxonomy_name',null);
      if(!is_null($tag_type) && !is_null($tag_name) && $tag_type != "not selected" && $tag_name != "not selected")
      {
        $tax = !Taxonomy::findOne(['type'=>$tag_type,'name'=>$tag_name])? null : Taxonomy::findOne(['type'=>$tag_type,'name'=>$tag_name]);
        //if new Taxonomy -> Save
        if(is_null($tax))
        {
          $taxonomy = new Taxonomy();
          $taxonomy->type = $tag_type;
          $taxonomy->name = $tag_name;
          if(!$taxonomy->save()) return false;
          $model->taxonomy_id = $taxonomy->id;
        }
        //if isset Taxonomy -> Update
        else {
          $model->taxonomy_id = $tax->id;
        }
        if($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        else return $this->redirect('create');
      }
      else return $this->redirect('create');
    }
    /**
     * Finds the Term model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Term the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Term::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
