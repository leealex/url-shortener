Каждый переход фиксируется новой записью с `ID` ссылки и датой `created_at` в таблице `visit`. 

Для решения проблем с нагрузкой я бы воспользовался следующими вариантами:
- Настроить репликацию между двумя БД, в одну из которых записывались бы только переходы, а в другую записывались бы токены и из нее же читались переходы.
- На уровне сервера настроить балансировщик запросов посредством Nginx.
- Кэширование статистики за прошлые дни, т.к. эти жанные уже изменяться не будут. (В коде этой реализации нет, но могу дописать если потребуется). 

Попытался сэмулировать локально 5к запросов к сервису при помощи Yandex-Tank, но после пары итераций докер наглухо завис, похоже, локальное окружение не годится для подобного рода тестов.