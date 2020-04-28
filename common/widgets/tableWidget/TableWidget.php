<?php

namespace common\widgets\tableWidget;

class TableWidget extends \yii\base\Widget
{
    public $table = [];
    public $labels = [];

    public function run()
    {
        if (!($this->getColumns() or count($this->table))) {
            echo "Ничего не найдено";
        } else {
            $this->renderTable();
        }
    }

    private function renderTable()
    {
        echo "<table class=\"table table-bordered\">";
        $this->renderThead();
        $this->renderTbody();
        echo " </table>";
    }


    private
    function getColumns()
    {
        return current($this->table) ? array_keys(current($this->table)) : 0;
    }

    private function getColumnLabel($column)
    {
        return isset($this->labels[$column]) ? $this->labels[$column] : $column;
    }

    private function renderThead()
    {
        echo "<tr>";
        foreach ($this->getColumns() as $column) {
            echo "<th>";
            echo $this->getColumnLabel($column);
            echo "</th>";
        }
        echo "</tr>";
    }

    private function renderTbody()
    {

        foreach ($this->table as $row) {
            echo "<tr>";
            $this->renderRow($row);
            echo "</tr>";
        }
    }

    private function renderRow($row)
    {
        foreach ($this->getColumns() as $cell) {
            echo "<td>";
            echo $row[$cell];
            echo "</td>";
        }
    }
}