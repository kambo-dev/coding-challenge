<?php


namespace App\Repositories\Classes;


use App\Repositories\Contracts\BaseEloquentRepositoryInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository implements BaseEloquentRepositoryInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var Model|Builder
     */
    protected Model|Builder $model;

    /**
     * @param Application $app
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model){
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * @return Model|Builder
     */
    abstract protected function model();

    /**
     * Begin querying the model.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->query();
    }
}
