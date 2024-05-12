<?php



namespace app\core\form;

use app\core\Model;

class Field
{
    public Model $model;
    public $attribute;
    public $type;

    public function __construct(Model $model, $attribute, $type)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = $type;
    }

    public function __toString()
    {
        return sprintf('
        <div class="mb-3">
           <label class="form-label">%s</label>
           <input type="%s" class="form-control %s" name="%s"/>

           <div class="invalid-feedback">
            %s
           </div>
        </div>
    ', $this->model->labels()[$this->attribute], $this->type, $this->model->hasError($this->attribute) ? 'is-invalid' : '', $this->attribute, $this->model->getFirstError($this->attribute));
    }
}
