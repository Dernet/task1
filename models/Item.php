<?php

/**
 * Класс Item - модель для работы с задачами
 */
class Item {

     // Количество отображаемых задач по умолчанию
     const SHOW_BY_DEFAULT = 3;

    /**
     * Возвращает массив задач
     * @return array <p>Массив с задачами</p>
     */
    public static function getAllItems($page = 1, $sort_field, $sort_order) {
        $limit = Item::SHOW_BY_DEFAULT;
        // Смещение (для запроса)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();

        $sql = 'SELECT * FROM items 
            ORDER BY '. $sort_field . ' ' . $sort_order 
            . ' LIMIT :limit OFFSET :offset';

        $result = $db->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        // $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $itemsList = array();
        while ($row = $result->fetch()) {
            $itemsList[$i]['id'] = $row['id'];
            $itemsList[$i]['username'] = $row['username'];
            $itemsList[$i]['email'] = $row['email'];
            $itemsList[$i]['item_text'] = $row['item_text'];
            $itemsList[$i]['status'] = $row['status'];
            $itemsList[$i]['edited_by_admin'] = $row['edited_by_admin'];
            $i++;
        }
        return $itemsList;
    }

    /**
     * Возвращаем количество товаров в указанной категории
     * @param integer $categoryId
     * @return integer
     */
    public static function getTotalItems()
    {
        $db = Db::getConnection();

        $sql = 'SELECT count(id) AS count FROM items';

        $result = $db->prepare($sql);

        $result->execute();

        // Возвращаем значение count - количество
        $row = $result->fetch();
        return $row['count'];
    }

    /**
     * Добавляет новую задачу
     * @param array $options <p>Массив с информацией о задаче</p>
     * @return integer <p>id добавленной в таблицу записи</p>
     */
    public static function createItem($options) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO items '
                . '(username, email, item_text) '
                . 'VALUES '
                . '(:username, :email, :item_text)';

        $result = $db->prepare($sql);
        $result->bindParam(':username', $options['username'], PDO::PARAM_STR);
        $result->bindParam(':email', $options['email'], PDO::PARAM_STR);
        $result->bindParam(':item_text', $options['item_text'], PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /**
     * Возвращает задачу с указанным id
     * @param integer $id <p>id задачи</p>
     * @return array <p>Массив с информацией о задаче</p>
     */
    public static function getItemById($id)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM items WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $result->execute();

        return $result->fetch();
    }

    /**
     * Редактирует задачу с заданным id
     * @param integer $id <p>id задачи</p>
     * @param array $options <p>Массив с информацей о задаче</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateItemById($id, $options)
    {
        $db = Db::getConnection();

        $sql = "UPDATE items
            SET 
                item_text = :item_text, 
                status = :status, 
                edited_by_admin = :edited_by_admin 
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':item_text', $options['item_text'], PDO::PARAM_STR);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $result->bindParam(':edited_by_admin', $options['edited_by_admin'], PDO::PARAM_INT);
        
        return $result->execute();
    }

    /**
     * Проверяет формат email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}