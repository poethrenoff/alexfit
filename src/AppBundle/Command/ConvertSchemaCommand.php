<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;

use Fresh\Transliteration\Transliterator;

class ConvertSchemaCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('app:convert-schema')
            ->setDescription('Imports pdoduct data.')
            ->setHelp("This command imports pdoduct data from old dump.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getDoctrineConnection('default');
        
        $connection->executeUpdate('SET foreign_key_checks = 0');
            $connection->executeUpdate('truncate product_picture');
            $connection->executeUpdate('truncate product');
            $connection->executeUpdate('truncate category');
            $connection->executeUpdate('truncate catalogue');
            $connection->executeUpdate('truncate brand');
            $connection->executeUpdate('truncate article');
        $connection->executeUpdate('SET foreign_key_checks = 1');
        
        
        // Статьи
        $stmt = $connection->prepare('select * from articles order by article_id');
        $stmt->execute();
        $article_list = $stmt->fetchAll();
        
        $article_map = array();
        foreach ($article_list as $article_item) {
            $connection->insert('article', array(
                'article_title' => $article_item['article_title'],
                'article_announce' => $article_item['article_announce'],
                'article_text' => $article_item['article_text'],
                'article_active' => 1,
            ));
            $article_map[$article_item['article_id']] = $connection->lastInsertId();
        }
        
        
        // Бренды
        $stmt = $connection->prepare('select * from brands order by brand_id');
        $stmt->execute();
        $brand_list = $stmt->fetchAll();
        
        $brand_map = array();
        foreach ($brand_list as $brand_item) {
            $connection->insert('brand', array(
                'brand_title' => $brand_item['brand_name'],
                'brand_country' => $brand_item['brand_country'],
            ));
            $brand_map[$brand_item['brand_id']] = $connection->lastInsertId();
        }
        
        
        // Группы
        $stmt = $connection->prepare('select * from groups order by group_order');
        $stmt->execute();
        $group_list = $stmt->fetchAll();
        
        $catalogue_map = array(); $catalogue_order = 1;
        foreach ($group_list as $group_item) {
            $connection->insert('catalogue', array(
                'catalogue_title' => $group_item['group_name'],
                'catalogue_name' => $this->transliterate($group_item['group_name']),
                'catalogue_description' => $group_item['group_comment'],
                'catalogue_order' => $catalogue_order++,
                'catalogue_active' => $group_item['group_active'],
            ));
            $catalogue_map[$group_item['group_id']] = $connection->lastInsertId();
        }
        
        
        // Категории
        $stmt = $connection->prepare('select * from categories order by group_id, category_order');
        $stmt->execute();
        $category_list = $stmt->fetchAll();
        
        $category_map = array(); $category_catalogue_map = array();
        
        $category_picture_url = 'http://alexfit.ru/images/categories/';
        $category_picture_default = 'default.gif';
        $category_picture_path = 'web/upload/category/';
        $category_picture_alias = '/upload/category/';
        
        foreach ($category_list as $category_item) {
            $category_catalogue = $catalogue_map[$category_item['group_id']];
            @$category_catalogue_map[$category_catalogue]++;
            
            if (empty($category_item['category_picture'])) {
                $category_item['category_picture'] = $category_picture_default;
            } 
            if (!file_exists($category_picture_path . $category_item['category_picture'])) {
                $category_picture_data = file_get_contents($category_picture_url . $category_item['category_picture']);
                file_put_contents($category_picture_path . $category_item['category_picture'], $category_picture_data);
            }
            
            $connection->insert('category', array(
                'category_catalogue' => $category_catalogue,
                'category_title' => $category_item['category_name'],
                'category_short_title' => $category_item['category_short_name'],
                'category_name' => $this->transliterate($category_item['category_short_name']),
                'category_description' => $category_item['category_comment'],
                'category_picture' => $category_picture_alias . $category_item['category_picture'],
                'category_order' => $category_catalogue_map[$category_catalogue],
                'category_active' => $category_item['category_active'],
            ));
            $category_map[$category_item['category_id']] = $connection->lastInsertId();
        }
        
        
        // Товары
        $stmt = $connection->prepare('select * from products order by category_id, product_id');
        $stmt->execute();
        $product_list = $stmt->fetchAll();
        
        $product_map = array(); $catalogue_product_map = array();
        
        $product_picture_url = 'http://alexfit.ru/images/products/big/';
        $product_picture_additional_url = 'http://alexfit.ru/images/products/additional/';
        $product_picture_default = 'default.gif';
        $product_picture_path = 'web/upload/product/';
        $product_picture_alias = '/upload/product/';
        
        $product_instruction_url = 'http://alexfit.ru/instructions/';
        $product_instruction_path = 'web/upload/instruction/';
        $product_instruction_alias = '/upload/instruction/';
        
        foreach ($product_list as $product_item) {
            $product_brand = $brand_map[$product_item['brand_id']];
            $product_category = $category_map[$product_item['category_id']];
            @$catalogue_product_map[$product_category]++;
            
            if (empty($product_item['product_picture'])) {
                $product_item['product_picture'] = $product_picture_default;
            }
            if (!file_exists($product_picture_path . $product_item['product_picture'])) {
                $product_picture_data = file_get_contents($product_picture_url . $product_item['product_picture']);
                file_put_contents($product_picture_path . $product_item['product_picture'], $product_picture_data);
            }
            
            if (!empty($product_item['product_instruct'])) {
                if (!file_exists($product_instruction_path . $product_item['product_instruct'])) {
                    $product_instruction_data = file_get_contents($product_instruction_url . $product_item['product_instruct']);
                    file_put_contents($product_instruction_path . $product_item['product_instruct'], $product_instruction_data);
                }
            }
            $connection->insert('product', array(
                'product_brand' => $product_brand,
                'product_category' => $product_category,
                'product_title' => $product_item['product_name'],
                'product_price' => $product_item['product_price'],
                'product_price_old' => 0,
                'product_short_desctiption' => $product_item['product_short_desc'],
                'product_full_desctiption' => $product_item['product_full_desc'],
                'product_instruction' => $product_item['product_instruct'] ? $product_instruction_alias . $product_item['product_instruct'] : null,
                'product_active' => $product_item['product_active'],
            ));
            $product_id = $connection->lastInsertId();
            
            $product_picture_map = array();
            @$product_picture_map[$product_id]++;
            
            $connection->insert('product_picture', array(
                'picture_product' => $product_id,
                'picture_image' => $product_picture_alias . $product_item['product_picture'],
                'picture_order' => $product_picture_map[$product_id],
            ));
            
            // Картинки товаров
            $stmt = $connection->prepare('select * from product_pictures where product_id = :product_id order by product_id, picture_id');
            $stmt->execute(array('product_id' => $product_item['product_id']));
            $picture_product_list = $stmt->fetchAll();
        
            foreach ($picture_product_list as $product_picture_item) {
                @$product_picture_map[$product_id]++;

                if (empty($product_picture_item['picture_name'])) {
                    $product_picture_item['picture_name'] = $product_picture_default;
                }
                if (!file_exists($product_picture_path . $product_picture_item['picture_name'])) {
                    $product_picture_data = file_get_contents($product_picture_additional_url . $product_picture_item['picture_name']);
                    file_put_contents($product_picture_path . $product_picture_item['picture_name'], $product_picture_data);
                }
                
                $connection->insert('product_picture', array(
                    'picture_product' => $product_id,
                    'picture_image' => $product_picture_alias . $product_picture_item['picture_name'],
                    'picture_order' => $product_picture_map[$product_id],
                ));
            }
        }
    }
    
    protected function transliterate(string $text)
    {
        $transliterator = new Transliterator();
        
        $result = $transliterator->ruToEn($text);
        
        $result = preg_replace('/\s+/', '-', $result);
        $result = preg_replace('/[^A-z-]/', '', $result);
        $result = strtolower($result);
        
        return $result; 
    }
}