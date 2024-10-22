<?php
namespace AppBundle\Command;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPicture;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;

class ImportProductFileCommand extends DoctrineCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import-product:file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->csvReader = fopen("/var/www/var/products-2024-10-15.csv", 'r+');

        $manager = $this->getDoctrine()->getManager();

        $categories = [
            59 => 1, 60 => 2, 61 => 5, 63 => 3, 64 => 4,
        ];

        fgetcsv($this->csvReader, 0, ";");
        while (($item = fgetcsv($this->csvReader, 0, ";")) !== false) {
            if (in_array($item[2], array_keys($categories))) {
                $category = $manager->getRepository('AppBundle:Category')
                    ->find($categories[$item[2]]);

                if (isset($item[3]) and $item[3]) {
                    $brand = $manager->getRepository('AppBundle:Brand')
                        ->findOneBy(["brand_title" => $item[3]]);
                    if (!$brand) {
                        $brand = new Brand();
                        $brand->setBrandTitle($item[3]);
                        $manager->persist($brand);
                        $manager->flush();
                    }
                } else {
                    $brand = $manager->getRepository('AppBundle:Brand')->find(10);
                }

                $product = $manager->getRepository('AppBundle:Product')
                    ->findOneBy(["product_title" => $item[1]]);
                if (!$product) {
                    $product = new Product();
                    $product->setProductCategory($category);
                    $product->setProductBrand($brand);
                    $product->setProductTitle($item[1]);
                    $product->setProductPrice((float)str_replace(",", ".", $item[5]));
                    $product->setProductFullDescription($item[6]);
                    $product->setProductActive(true);
                    $manager->persist($product);
                    $manager->flush();

                    $filename = "/var/www/html/upload/product/" . basename($item[4]);
                    if (!file_exists($filename)) {
                        if ($content = @file_get_contents($item[4])) {
                            file_put_contents($filename, $content);
                        } else {
                            break;
                        }
                    }

                    $product_picture = new ProductPicture();
                    $product_picture->setPictureProduct($product);
                    $product_picture->setPictureImage("/upload/product/" . basename($item[4]));
                    $product_picture->setPictureOrder(0);
                    $manager->persist($product_picture);
                    $manager->flush();

                    print_r($item);
                }
            }
        }
    }
}