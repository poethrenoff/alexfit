<?php
namespace AppBundle\Command;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPicture;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;

class ImportProductXMLCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import-product:xml');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->xmlReader = new \XMLReader();
        $this->xmlReader->open('/var/www/var/hasttings.ru.xml');

        $manager = $this->getDoctrine()->getManager();

        $categories = [
            9 => 5, 13 => 5, 12 => 4, 15 => 4, 19 => 3, 20 => 3, 30 => 3,
            28 => 1, 29 => 1, 31 => 2, 11 => 2, 34 => 10, 46 => 10,
            45 => 15, 47 => 15,
        ];

        while ($this->xmlReader->read()) {
            switch ($this->xmlReader->nodeType) {
                case \XmlReader::ELEMENT:
                    $field = $this->xmlReader->name;
                    if (!($itemNode = @$this->xmlReader->expand())) {
                        throw new \Exception('Feed parse error.');
                    }

                    if ($field == "offer") {
                        $item = static::toArray($itemNode);
                        foreach ($itemNode->attributes as $attribute) {
                            $item[$attribute->nodeName] = $attribute->nodeValue;
                        }

                        if (in_array($item['categoryId'], array_keys($categories))) {
                            $category = $manager->getRepository('AppBundle:Category')
                                ->find($categories[$item['categoryId']]);

                            if (isset($item['vendor'])) {
                                $brand = $manager->getRepository('AppBundle:Brand')
                                    ->findOneBy(["brand_title" => $item['vendor']]);
                                if (!$brand) {
                                    $brand = new Brand();
                                    $brand->setBrandTitle($item['vendor']);
                                    $manager->persist($brand);
                                    $manager->flush();
                                }
                            } else {
                                $brand = $manager->getRepository('AppBundle:Brand')->find(10);
                            }

                            $product = $manager->getRepository('AppBundle:Product')
                                ->findOneBy(["product_title" => $item['name']]);
                            if (!$product) {
                                $product = new Product();
                                $product->setProductCategory($category);
                                $product->setProductBrand($brand);
                                $product->setProductTitle($item['name']);
                                $product->setProductPrice($item['price']);
                                $product->setProductActive(true);
                                $manager->persist($product);
                                $manager->flush();

                                if (isset($item["picture"])) {
                                    foreach ((array)$item["picture"] as $productOrder => $picture) {
                                        $filename = "/var/www/html/upload/product/" . basename($picture);
                                        if (!file_exists($filename)) {
                                            if ($content = @file_get_contents($picture)) {
                                                file_put_contents($filename, $content);
                                            } else {
                                                break;
                                            }
                                        }

                                        $product_picture = new ProductPicture();
                                        $product_picture->setPictureProduct($product);
                                        $product_picture->setPictureImage("/upload/product/" . basename($picture));
                                        $product_picture->setPictureOrder($productOrder);
                                        $manager->persist($product_picture);
                                        $manager->flush();                                    }
                                }

                                print_r($item);
                            }
                        }
                    }

                    break;
            }
        }
    }

    /**
     * @param \DOMNode $parentNode
     * @return array
     */
    public static function toArray(\DOMNode $parentNode)
    {
        $result = [];
        foreach ($parentNode->childNodes as $node) {
            if ($node->nodeType == XML_ELEMENT_NODE) {
                $value = (count($node->childNodes) > 1) ? static::toArray($node) : $node->nodeValue;
                if (isset($result[$node->nodeName])) {
                    if (!is_array($result[$node->nodeName]) || array_keys($result[$node->nodeName])[0]) {
                        $result[$node->nodeName] = [$result[$node->nodeName]];
                    }
                    $result[$node->nodeName][] = $value;
                } else {
                    $result[$node->nodeName] = $value;
                }
            }
        }

        return $result;
    }
}