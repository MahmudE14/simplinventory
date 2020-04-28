<?php

class Manage
{
    private $con;

    function __construct()
    {
        include_once("../database/db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function manageRecordWithPagination($table, $page_no)
    {
        if ($table == 'categories') {
            $p_data = $this->pagination($this->con, $table, $page_no, 5);
            $sql = "SELECT p.category_name AS category, c.category_name AS parent, p.cid, p.status FROM categories p LEFT JOIN categories c ON p.parent_cat = c.cid " . $p_data["limit"];
        }
        $result = $this->con->query($sql) or die($this->con->error);
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return ['rows' => $rows, "pagination" => $p_data["pagination"]];
    }

    private function pagination($con, $table, $pno, $n)
    {
        $res = $con->query("SELECT COUNT(*) as `rows` FROM " . $table);
        $row = $res->fetch_assoc();
        $pageno = $pno;
        $numberOfRecordsPerPage = $n;
        $last_page = ceil($row["rows"] / $numberOfRecordsPerPage);
        $pagination = "<ul class='pagination'>";
        if ($last_page != 1) {
            // if present page > 1
            if ($pageno > 1) {
                $previous = "";
                $previous = $pageno - 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $previous . "' href='#' style='color:#333;'> Previous </a></li>";
            }
            // previous pages
            for ($i = $pageno - 5; $i < $pageno; $i++) {
                // only positive result
                if ($i > 0) {
                    $pagination .= "<li class='page-item'><a class='page-link' pn='" . $i . "' href='#'> " . $i . " </a></li>";
                }
            }

            // present page
            $pagination .= "<li class='page-item'><a class='page-link' pn='" . $pageno . "' href='#' style='color:#333;'> $pageno </a></li>";

            // next pages
            for ($i = $pageno + 1; $i <= $last_page; $i++) {
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $i . "' href='#'> " . $i . " </a></li>";
                // only next 5 pages
                if ($i > $pageno + 4) {
                    break;
                }
            }

            // if more page available after present
            if ($last_page > $pageno) {
                $next = $pageno + 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='" . $next . "' href='#' style='color:#333;'> Next </a></li></ul>";
            }
        }

        $limit = "LIMIT " . ($pageno - 1) * $numberOfRecordsPerPage . "," . $numberOfRecordsPerPage;

        return ["pagination" => $pagination, "limit" => $limit];
    }

    public function deleteRecord($table, $pk, $id)
    {
        if ($table == "categories") { // if parent category, don't delete
            $pre_stmt = $this->con->prepare("SELECT ? FROM categories WHERE parent_cat = ?");
            $pre_stmt->bind_param('ii', $id, $id);
            $pre_stmt->execute();
            $result = $pre_stmt->get_result() or die($this->con->error);
            if ($result->num_rows > 0) {
                return "DEPENDANT_CATEGORY";
            } else { // delete
                $pre_stmt = $this->con->prepare("DELETE FROM " . $table . " WHERE ". $pk ." = ?");
                $pre_stmt->bind_param("i", $id);
                $result = $pre_stmt->execute() or die($this->con->error);
                if ($result) {
                    return "CATEGORY_DELETED";
                }
            }
        } else { // delete
            $pre_stmt = $this->con->prepare("DELETE FROM ? WHERE ? = ?");
            $pre_stmt->bind_param("ssi", $table, $pk, $id);
            $pre_stmt->execute();
            $result = $pre_stmt->get_result() or die($this->con->error);
            if ($result) {
                return "DELETED";
            }
        }
    }

    public function getSingleCategory($table, $pk, $id)
    {
        $pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE ".$pk." = ? LIMIT 1");
        $pre_stmt->bind_param("i", $id);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }
        return $row;
    }

    public function updateCategory($table, $pk, $id)
    {
        # code...
    }

    public function updateRecords($table, $where, $fields)
    {
        $set_fields = "";
        $condition = "";

        // WHERE k = v
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }

        $condition = substr($condition , 0, -5);

        // SET key = value
        foreach ($fields as $key => $value) {
            $set_fields .= $key . " = '" . $value . "', ";
        }

        $set_fields = substr($set_fields, 0, -2);

        $sql = "UPDATE " . $table . " SET " . $set_fields . " WHERE " . $condition;

        if ($this->con->query($sql)) {
            return "UPDATED";
        } else {
            return $this->con->error;
        }
    }
}

// $obj = new Manage();
// echo "<pre>";
// print_r($obj->manageRecordWithPagination('categories', 1));
// echo $obj->deleteRecord("categories", "cid", 17);
// print_r($obj->getSingleCategory('categories', 'cid', 3));
// echo $obj->updateRecords("categories", ["cid" => 1], ["parent_cat" => "0", "category_name" => "Electro", "status" => 1]);

