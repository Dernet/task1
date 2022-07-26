<?php

/**
 * Контроллер ItemsController
 */

class ItemsController extends AdminBase {
    /**
     * Action для добавления Item
     */
    public function actionCreate() {
        // Обработка формы
        if (isset($_POST['submit'])) {
            $options['username'] = strip_tags($_POST['username']); // avoid html tags
            $options['email'] = strip_tags($_POST['email']); // avoid html tags
            $options['item_text'] = strip_tags($_POST['item_text']); // avoid html tags

            // Флаг ошибок в форме
            $errors = false;

            if (!isset($options['username']) || empty($options['username'])) {
                $errors[] = 'Заполните полe имени';
            }

            if (!isset($options['email']) || empty($options['email'])) {
                $errors[] = 'Заполните полe email';
            }

            if (!Item::checkEmail($options['email'])) {
                $errors[] = 'Неправильный формат email';
            }

            if (!isset($options['item_text']) || empty($options['item_text'])) {
                $errors[] = 'Заполните полe текста задачи';
            }

            if ($errors == false) {
                $id = Item::createItem($options);
                if($id) {
                    $_SESSION['success'] = 'Задача успешно добавлена';
                } else {
                    $_SESSION['error_message'] = 'Ошибка сохранения';
                }

                header("Location: /");
            }
        }

        require_once(ROOT . '/views/site/create_item.php');
        return true;
    }

    /**
     * Action для страницы "Редактировать задачу"
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем данные о конкретной задаче
        $item = Item::getItemById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            $options['item_text'] = strip_tags($_POST['item_text']); //avoid html
            $options['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

            // Если текст задачи отредактирован пользователем
            if($options['item_text'] != $Item['item_text']) {
                $options['edited_by_admin'] = 1;
            } else {
                $options['edited_by_admin'] = $item['edited_by_admin'];
            }

            if(Item::updateItemById($id, $options)) {
                $_SESSION['success'] = 'Задача успешно изменена';
            }else {
                $_SESSION['error_message'] = 'Ошибка сохранения';
            }
        
            header("Location: /");
        }

        // Подключаем вид
        require_once(ROOT . '/views/site/update_item.php');
        return true;
    }
}