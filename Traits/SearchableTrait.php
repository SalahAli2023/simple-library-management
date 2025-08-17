<?php
trait SearchableTrait {
    protected function search($table, $columns, $searchTerm) {
        $db = Database::getInstance()->getConnection();
        
        $searchConditions = [];
        foreach ($columns as $column) {
            $searchConditions[] = "$column LIKE :searchTerm";
        }
        
        $query = "SELECT * FROM $table WHERE " . implode(' OR ', $searchConditions);
        $stmt = $db->prepare($query);
        $stmt->bindValue(':searchTerm', "%$searchTerm%");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}