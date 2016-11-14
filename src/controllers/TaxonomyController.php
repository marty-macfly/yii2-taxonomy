<?php

namespace macfly\taxonomy\controllers;

use Yii;
use macfly\taxonomy\models\Taxonomy;
use macfly\taxonomy\models\Term;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TaxonomyController implements the CRUD actions for Taxonomy model.
 */
class TaxonomyController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Taxonomy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $taxonomies = Taxonomy::find()->all();
        return $this->render('index', [
            'taxonomies' => $taxonomies,
        ]);
    }

    /**
     * Displays a single Taxonomy model.
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
     * Creates a new Taxonomy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Taxonomy();
        $terms = Term::find()->all();
        if ($model->load(Yii::$app->request->post()))
        {
          //if taxonomy input not existing in database
          if(!Taxonomy::findOne(['type'=>Yii::$app->request->post("Taxonomy")['type'],'name'=>Yii::$app->request->post("Taxonomy")['name']]) && $model->save())
          {
            //if Taxonomy -> saved -> update term assigned on this
            $this->syncTerm($model);
          }
          else return $this->render('create', ['model' => $model,'terms'=>$terms]);
        }
        else {
            return $this->render('create', [
                'model' => $model,'terms'=>$terms
            ]);
        }
    }

    /**
     * Updates an existing Taxonomy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $terms = Term::find()->all();
        $term_assigned = ArrayHelper::getColumn(Term::findAll(['taxonomy_id'=>$id]), 'id');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              $this->syncTerm($model);
        } else {
            return $this->render('update', [
                'model' => $model,'terms'=>$terms,'term_assigned'=>$term_assigned
            ]);
        }
    }

    private function syncTerm($model)
    {
        //can only attach Taxonomy to Term, cannot detach taxonomy from term
        $term_to_assign = Yii::$app->request->post('terms_input',null);
        if(!is_null($term_to_assign))
        {
          $term_to_assign = is_array($term_to_assign) ? $term_to_assign : [$term_to_assign];
          foreach($term_to_assign as $id)
          {
            $current_term = Term::findOne($id);
            $current_term->taxonomy_id = $model->id;
            $current_term->update();
          }
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }
    /**
     * Deletes an existing Taxonomy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Taxonomy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Taxonomy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Taxonomy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
