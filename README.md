# 用 Laravel8 开发的诗词 api

## 安装

1. 先把项目克隆到本地

```
git clone https://github.com/ibyond/poetry_api.git
```

2. 打开项目目录，下载依赖扩展包

```
composer install
```

3. 复制配置文件

```
cp .env.example .env
```

自行配置`.env`里的相关配置信息

4. 生成`APP_KEY`和`JWT_SECRET`
```
php artisan key:generate
php artisan jwt:secret
```

5. 导入数据

解压 public 目录下的数据库文件导入数据
