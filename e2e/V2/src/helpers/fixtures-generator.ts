import { spawn } from "child_process";
import {colorText} from "@helpers/utils";

interface ShopCreatorOptions {
  orders?: number;
  customers?: number;
  carts?: number;
  shopId?: number;
  shopGroupId?: number;
  languageId?: number;
}

export function runShopCreator(options: ShopCreatorOptions): Promise<void> {
  return new Promise((resolve, reject) => {
    const args = [
      "exec",
      "-i",
      "ps_eventbus-prestashop-local-1",
      "php",
      "bin/console",
      "prestashop:shop-creator"
    ];

    if (options.orders !== undefined) args.push(`--orders=${options.orders}`);
    if (options.customers !== undefined) args.push(`--customers=${options.customers}`);
    if (options.carts !== undefined) args.push(`--carts=${options.carts}`);
    if (options.shopId !== undefined) args.push(`--shopId=${options.shopId}`);
    if (options.shopGroupId !== undefined) args.push(`--shopGroupId=${options.shopGroupId}`);
    if (options.languageId !== undefined) args.push(`--languageId=${options.languageId}`);

    const child = spawn("docker", args);

    child.stdout.on("data", (data) => process.stdout.write(colorText(data.toString(), ["green", "bold", "italic"])));
    child.stderr.on("data", (data) => process.stderr.write(colorText(data.toString(), ["green", "bold", "italic"])));

    child.on("close", (code) => {
      if (code === 0) resolve();
      else reject(new Error(`shop-creator exited with code ${code}`));
    });
  });
}

interface ProductsCreatorOptions {
  products?: number;
  productsWithCombinations?: number;
  shopId?: number;
  attributeGroups?: number;
  attributes?: number;
  features?: number;
  images?: number;
}

export function runProductsCreator(options: ProductsCreatorOptions): Promise<void> {
  return new Promise((resolve, reject) => {
    const args = [
      "exec",
      "-i",
      "ps_eventbus-prestashop-local-1",
      "php",
      "bin/console",
      "prestashop:product-creator"
    ];

    if (options.products !== undefined) args.push(`--products=${options.products}`);
    if (options.productsWithCombinations !== undefined)
      args.push(`--productsWithCombinations=${options.productsWithCombinations}`);
    if (options.shopId !== undefined) args.push(`--shopId=${options.shopId}`);
    if (options.attributeGroups !== undefined) args.push(`--attributeGroups=${options.attributeGroups}`);
    if (options.attributes !== undefined) args.push(`--attributes=${options.attributes}`);
    if (options.features !== undefined) args.push(`--features=${options.features}`);
    if (options.images !== undefined) args.push(`--images=${options.images}`);

    const child = spawn("docker", args);

    child.stdout.on("data", (data) => process.stdout.write(colorText(data.toString(), ["green", "bold", "italic"])));
    child.stderr.on("data", (data) => process.stderr.write(colorText(data.toString(), ["green", "bold", "italic"])));

    child.on("close", (code) => {
      if (code === 0) resolve();
      else reject(new Error(`products-creator exited with code ${code}`));
    });
  });
}
