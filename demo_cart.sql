-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2018 at 08:03 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(40) NOT NULL,
  `url` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `caption` varchar(40) NOT NULL,
  `html` text,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `url`, `image`, `caption`, `html`, `start_date`, `end_date`) VALUES
(1, 'cool shades', '', 'assets/images/857b849f7ac5e5340d16667e80bef133.jpg', '', NULL, '2017-06-26', '2018-06-26'),
(2, 'cool hat', '', 'assets/images/c98b5fac90f523b92489958f4fb90626.jpg', '', NULL, '2017-06-26', '2018-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `cart_config`
--

CREATE TABLE `cart_config` (
  `config_id` tinyint(1) NOT NULL,
  `config_pagination_limit` smallint(5) NOT NULL DEFAULT '36',
  `config_user_files_limit` smallint(5) NOT NULL DEFAULT '5',
  `config_order_number_prefix` varchar(50) NOT NULL DEFAULT '',
  `config_order_number_suffix` varchar(50) NOT NULL DEFAULT '',
  `config_increment_order_number` tinyint(1) NOT NULL DEFAULT '0',
  `config_min_order` smallint(5) NOT NULL DEFAULT '0',
  `config_quantity_decimals` tinyint(1) NOT NULL DEFAULT '0',
  `config_quantity_limited_by_stock` tinyint(1) NOT NULL DEFAULT '0',
  `config_increment_duplicate_items` tinyint(1) NOT NULL DEFAULT '0',
  `config_remove_no_stock_items` tinyint(1) NOT NULL DEFAULT '0',
  `config_auto_allocate_stock` tinyint(1) NOT NULL DEFAULT '0',
  `config_save_ban_shipping_items` tinyint(1) NOT NULL DEFAULT '0',
  `config_weight_type` varchar(25) NOT NULL DEFAULT '',
  `config_weight_decimals` tinyint(1) NOT NULL DEFAULT '0',
  `config_display_tax_prices` tinyint(1) NOT NULL DEFAULT '0',
  `config_price_inc_tax` tinyint(1) NOT NULL DEFAULT '0',
  `config_multi_row_duplicate_items` tinyint(1) NOT NULL DEFAULT '0',
  `config_dynamic_reward_points` tinyint(1) NOT NULL DEFAULT '0',
  `config_reward_point_multiplier` double(8,4) NOT NULL DEFAULT '0.0000',
  `config_reward_voucher_multiplier` double(8,4) NOT NULL DEFAULT '0.0000',
  `config_reward_voucher_ratio` smallint(5) NOT NULL DEFAULT '0',
  `config_reward_point_days_pending` smallint(5) NOT NULL DEFAULT '0',
  `config_reward_point_days_valid` smallint(5) NOT NULL DEFAULT '0',
  `config_reward_voucher_days_valid` smallint(5) NOT NULL DEFAULT '0',
  `config_custom_status_1` varchar(50) NOT NULL DEFAULT '',
  `config_custom_status_2` varchar(50) NOT NULL DEFAULT '',
  `config_custom_status_3` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_config`
--

INSERT INTO `cart_config` (`config_id`, `config_pagination_limit`, `config_user_files_limit`, `config_order_number_prefix`, `config_order_number_suffix`, `config_increment_order_number`, `config_min_order`, `config_quantity_decimals`, `config_quantity_limited_by_stock`, `config_increment_duplicate_items`, `config_remove_no_stock_items`, `config_auto_allocate_stock`, `config_save_ban_shipping_items`, `config_weight_type`, `config_weight_decimals`, `config_display_tax_prices`, `config_price_inc_tax`, `config_multi_row_duplicate_items`, `config_dynamic_reward_points`, `config_reward_point_multiplier`, `config_reward_voucher_multiplier`, `config_reward_voucher_ratio`, `config_reward_point_days_pending`, `config_reward_point_days_valid`, `config_reward_voucher_days_valid`, `config_custom_status_1`, `config_custom_status_2`, `config_custom_status_3`) VALUES
(1, 24, 5, '', '', 1, 0, 0, 1, 1, 0, 1, 0, 'gram', 0, 1, 1, 0, 1, 10.0000, 0.0100, 250, 14, 365, 365, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart_data`
--

CREATE TABLE `cart_data` (
  `cart_data_id` int(11) NOT NULL,
  `cart_data_user_fk` int(11) NOT NULL DEFAULT '0',
  `cart_data_array` text NOT NULL,
  `cart_data_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cart_data_readonly_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart_data`
--

INSERT INTO `cart_data` (`cart_data_id`, `cart_data_user_fk`, `cart_data_array`, `cart_data_date`, `cart_data_readonly_status`) VALUES
(1, 1, 'a:3:{s:5:"items";a:1:{s:32:"38b3eff8baf56627478ec76a704e9b52";a:15:{s:6:"row_id";s:32:"38b3eff8baf56627478ec76a704e9b52";s:2:"id";i:101;s:4:"name";s:35:"Item #101, minimum required fields.";s:8:"quantity";d:1;s:5:"price";d:20;s:14:"stock_quantity";b:0;s:14:"internal_price";d:20;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:3.333299999999999929656269159750081598758697509765625;}}s:7:"summary";a:9:{s:10:"total_rows";i:1;s:11:"total_items";d:1;s:12:"total_weight";d:0;s:19:"total_reward_points";d:200;s:18:"item_summary_total";d:20;s:14:"shipping_total";d:3.95000000000000017763568394002504646778106689453125;s:9:"tax_total";d:3.987999999999999989341858963598497211933135986328125;s:15:"surcharge_total";d:0;s:5:"total";d:23.949999999999999289457264239899814128875732421875;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"1";s:4:"name";s:20:"UK Standard Shipping";s:11:"description";s:8:"2-3 Days";s:5:"value";s:4:"3.95";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:3.333299999999999929656269159750081598758697509765625;s:12:"shipping_tax";d:0.65800000000000002930988785010413266718387603759765625;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:3.99129999999999984794385454733856022357940673828125;s:18:"cart_taxable_value";d:19.9566999999999978854248183779418468475341796875;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:1;s:12:"order_number";s:8:"00000001";}}}', '2017-06-02 00:13:16', 1),
(2, 1, 'a:3:{s:5:"items";a:2:{s:32:"62b3e8cbab25f7c393a0996f39d4a9f6";a:17:{s:6:"row_id";s:32:"62b3e8cbab25f7c393a0996f39d4a9f6";s:2:"id";s:3:"202";s:4:"name";s:38:"Item #202, added via form with options";s:8:"quantity";d:2;s:5:"price";d:27.5;s:7:"options";a:2:{s:6:"Colour";s:4:"Blue";s:4:"Size";s:6:"Medium";}s:11:"option_data";a:2:{s:6:"Colour";a:3:{i:0;s:3:"Red";i:1;s:5:"Green";i:2;s:4:"Blue";}s:4:"Size";a:3:{i:0;s:5:"Small";i:1;s:6:"Medium";i:2;s:5:"Large";}}s:14:"stock_quantity";b:0;s:14:"internal_price";d:27.5;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:4.58330000000000037374547900981269776821136474609375;}s:32:"6974ce5ac660610b44d9b9fed0ff9548";a:15:{s:6:"row_id";s:32:"6974ce5ac660610b44d9b9fed0ff9548";s:2:"id";i:103;s:4:"name";s:25:"Item #103, free shipping.";s:8:"quantity";d:1;s:5:"price";d:19.949999999999999289457264239899814128875732421875;s:13:"shipping_rate";d:0;s:14:"stock_quantity";b:0;s:14:"internal_price";d:19.949999999999999289457264239899814128875732421875;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:3.32500000000000017763568394002504646778106689453125;}}s:7:"summary";a:9:{s:10:"total_rows";i:2;s:11:"total_items";d:3;s:12:"total_weight";d:0;s:19:"total_reward_points";d:750;s:18:"item_summary_total";d:74.9500000000000028421709430404007434844970703125;s:14:"shipping_total";d:5.0999999999999996447286321199499070644378662109375;s:9:"tax_total";d:13.339999999999999857891452847979962825775146484375;s:15:"surcharge_total";d:0;s:5:"total";d:80.0499999999999971578290569595992565155029296875;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"2";s:4:"name";s:20:"UK Recorded Shipping";s:11:"description";s:8:"2-3 Days";s:5:"value";s:4:"5.10";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";d:1;s:10:"free_value";d:19.949999999999999289457264239899814128875732421875;s:11:"free_weight";d:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:1:{s:32:"6974ce5ac660610b44d9b9fed0ff9548";d:0;}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:12.4916999999999998038902049302123486995697021484375;s:12:"shipping_tax";d:0.84999999999999997779553950749686919152736663818359375;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:13.341699999999999448618837050162255764007568359375;s:18:"cart_taxable_value";d:66.7083999999999974761522025801241397857666015625;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:2;s:12:"order_number";s:8:"00000002";}}}', '2017-06-04 21:39:56', 1),
(3, 1, 'a:3:{s:5:"items";a:4:{s:32:"0768281a05da9f27df178b5c39a51263";a:15:{s:6:"row_id";s:32:"0768281a05da9f27df178b5c39a51263";s:2:"id";i:1021;s:4:"name";s:35:"Item #1021, multiple items at once.";s:8:"quantity";d:1;s:5:"price";d:20.629999999999999005240169935859739780426025390625;s:14:"stock_quantity";b:0;s:14:"internal_price";d:22.5;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.8754999999999999449329379785922355949878692626953125;}s:32:"93d65641ff3f1586614cf2c1ad240b6c";a:15:{s:6:"row_id";s:32:"93d65641ff3f1586614cf2c1ad240b6c";s:2:"id";i:1022;s:4:"name";s:35:"Item #1022, multiple items at once.";s:8:"quantity";d:2;s:5:"price";d:32.9500000000000028421709430404007434844970703125;s:14:"stock_quantity";b:0;s:14:"internal_price";d:35.9500000000000028421709430404007434844970703125;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:2.99549999999999982946974341757595539093017578125;}s:32:"ce5140df15d046a66883807d18d0264b";a:15:{s:6:"row_id";s:32:"ce5140df15d046a66883807d18d0264b";s:2:"id";i:1023;s:4:"name";s:35:"Item #1023, multiple items at once.";s:8:"quantity";d:1;s:5:"price";d:14.6699999999999999289457264239899814128875732421875;s:14:"stock_quantity";b:0;s:14:"internal_price";d:16;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.3335999999999998966160319469054229557514190673828125;}s:32:"7f6ffaa6bb0b408017b62254211691b5";a:15:{s:6:"row_id";s:32:"7f6ffaa6bb0b408017b62254211691b5";s:2:"id";i:112;s:4:"name";s:38:"Item #112, stock controlled, in-stock.";s:8:"quantity";d:1;s:5:"price";d:15.57000000000000028421709430404007434844970703125;s:14:"stock_quantity";s:2:"20";s:14:"internal_price";d:16.989999999999998436805981327779591083526611328125;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.4154999999999999804600747665972448885440826416015625;}}s:7:"summary";a:9:{s:10:"total_rows";i:4;s:11:"total_items";d:5;s:12:"total_weight";d:0;s:19:"total_reward_points";d:1169;s:18:"item_summary_total";d:116.7699999999999960209606797434389591217041015625;s:14:"shipping_total";d:13.660000000000000142108547152020037174224853515625;s:9:"tax_total";d:11.861999999999998323119143606163561344146728515625;s:15:"surcharge_total";d:0;s:5:"total";d:130.43000000000000682121026329696178436279296875;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:2:"12";s:4:"name";s:22:"Australia NSW Shipping";s:11:"description";s:7:"10 Days";s:5:"value";s:5:"14.90";s:8:"tax_rate";N;s:8:"location";a:2:{i:0;a:5:{s:11:"location_id";s:2:"11";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:1:"8";s:4:"name";s:3:"NSW";}i:1;a:5:{s:11:"location_id";s:1:"8";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:9:"Australia";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"GST";s:4:"rate";s:7:"10.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:2:{i:0;a:5:{s:11:"location_id";s:2:"11";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:1:"8";s:4:"name";s:3:"NSW";}i:1;a:5:{s:11:"location_id";s:1:"8";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:9:"Australia";}}s:4:"data";a:9:{s:14:"item_total_tax";d:10.615500000000000824229573481716215610504150390625;s:12:"shipping_tax";d:1.24199999999999999289457264239899814128875732421875;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";d:1.1857000000000113004716695286333560943603515625;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:10.6743000000000005655920176650397479534149169921875;s:18:"cart_taxable_value";d:106.715699999999998226485331542789936065673828125;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:1:{s:10:"10-PERCENT";a:3:{s:2:"id";s:1:"2";s:4:"code";s:10:"10-PERCENT";s:11:"description";s:49:"Discount Code "10-PERCENT" - 10% off grand total.";}}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:1:{s:5:"total";a:5:{s:2:"id";s:1:"2";s:4:"code";s:10:"10-PERCENT";s:11:"description";s:49:"Discount Code "10-PERCENT" - 10% off grand total.";s:9:"tax_value";d:1.1857000000000113004716695286333560943603515625;s:5:"value";d:13.0400000000000062527760746888816356658935546875;}}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";d:13.0400000000000062527760746888816356658935546875;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:3;s:12:"order_number";s:8:"00000003";}}}', '2017-06-07 19:06:36', 1),
(4, 1, 'a:3:{s:5:"items";a:2:{s:32:"37bc2f75bf1bcfe8450a1a41c200364c";a:15:{s:6:"row_id";s:32:"37bc2f75bf1bcfe8450a1a41c200364c";s:2:"id";i:304;s:4:"name";s:38:"Discount Item #304, Buy 2, get 1 free.";s:8:"quantity";d:3;s:5:"price";d:9.0299999999999993605115378159098327159881591796875;s:14:"stock_quantity";b:0;s:14:"internal_price";d:10;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:0.6974000000000000198951966012828052043914794921875;}s:32:"c4ca4238a0b923820dcc509a6f75849b";a:15:{s:6:"row_id";s:32:"c4ca4238a0b923820dcc509a6f75849b";s:2:"id";i:1;s:4:"name";s:24:"Example Database Item #1";s:8:"quantity";d:1;s:5:"price";d:22.5799999999999982946974341757595539093017578125;s:6:"weight";d:75;s:14:"stock_quantity";s:3:"100";s:14:"internal_price";d:25;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.7439999999999999946709294817992486059665679931640625;}}s:7:"summary";a:9:{s:10:"total_rows";i:2;s:11:"total_items";d:4;s:12:"total_weight";d:75;s:19:"total_reward_points";d:496;s:18:"item_summary_total";d:49.6700000000000017053025658242404460906982421875;s:14:"shipping_total";d:11.96000000000000085265128291212022304534912109375;s:9:"tax_total";d:4.76400000000000023447910280083306133747100830078125;s:15:"surcharge_total";d:0;s:5:"total";d:61.63000000000000255795384873636066913604736328125;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:2:"15";s:4:"name";s:23:"New York State Shipping";s:11:"description";s:6:"6 Days";s:5:"value";s:5:"13.25";s:8:"tax_rate";N;s:8:"location";a:3:{i:0;a:5:{s:11:"location_id";s:2:"18";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"3";s:9:"parent_id";s:2:"16";s:4:"name";s:5:"10101";}i:1;a:5:{s:11:"location_id";s:2:"16";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:2:"10";s:4:"name";s:8:"New York";}i:2;a:5:{s:11:"location_id";s:2:"10";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"United States";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:17:"Tax New York City";s:4:"rate";s:6:"8.3700";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:3:{i:0;a:5:{s:11:"location_id";s:2:"18";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"3";s:9:"parent_id";s:2:"16";s:4:"name";s:5:"10101";}i:1;a:5:{s:11:"location_id";s:2:"16";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:2:"10";s:4:"name";s:8:"New York";}i:2;a:5:{s:11:"location_id";s:2:"10";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"United States";}}s:4:"data";a:9:{s:14:"item_total_tax";d:3.836300000000000043343106881366111338138580322265625;s:12:"shipping_tax";d:0.92400000000000004352074256530613638460636138916015625;s:17:"item_discount_tax";d:0.6974000000000000198951966012828052043914794921875;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:4.06289999999999995594635038287378847599029541015625;s:18:"cart_taxable_value";d:48.54119999999999635065250913612544536590576171875;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:1:{s:32:"37bc2f75bf1bcfe8450a1a41c200364c";a:7:{s:2:"id";i:10;s:11:"description";s:38:"Discount Item #304, Buy 2, get 1 free.";s:17:"discount_quantity";d:1;s:21:"non_discount_quantity";d:2;s:9:"tax_value";d:0;s:5:"value";d:9.0299999999999993605115378159098327159881591796875;s:17:"shipping_discount";b:0;}}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:9.0299999999999993605115378159098327159881591796875;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:4;s:12:"order_number";s:8:"00000004";}}}', '2017-06-10 16:33:16', 1),
(5, 1, 'a:3:{s:5:"items";a:3:{s:32:"c81e728d9d4c2f636f067f89cc14862c";a:15:{s:6:"row_id";s:32:"c81e728d9d4c2f636f067f89cc14862c";s:2:"id";s:1:"2";s:4:"name";s:24:"Example Database Item #2";s:8:"quantity";d:1;s:5:"price";d:4.95000000000000017763568394002504646778106689453125;s:6:"weight";d:15;s:14:"stock_quantity";s:3:"100";s:14:"internal_price";d:4.95000000000000017763568394002504646778106689453125;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:0.8249999999999999555910790149937383830547332763671875;}s:32:"8ba32330170ca729c650f411edf3777e";a:16:{s:6:"row_id";s:32:"8ba32330170ca729c650f411edf3777e";s:2:"id";i:115;s:4:"name";s:19:"Item #115, options.";s:8:"quantity";d:1;s:5:"price";d:79.4899999999999948840923025272786617279052734375;s:7:"options";a:2:{s:14:"Option Type #1";s:9:"Option #1";s:14:"Option Type #2";s:9:"Option #2";}s:14:"stock_quantity";b:0;s:14:"internal_price";d:79.4899999999999948840923025272786617279052734375;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:13.248300000000000409272615797817707061767578125;}s:32:"2723d092b63885e0d7c260cc007e8b9d";a:15:{s:6:"row_id";s:32:"2723d092b63885e0d7c260cc007e8b9d";s:2:"id";i:109;s:4:"name";s:26:"Item #109, defined weight.";s:8:"quantity";d:1;s:5:"price";d:55;s:6:"weight";d:138;s:14:"stock_quantity";b:0;s:14:"internal_price";d:55;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:9.1667000000000005144329406903125345706939697265625;}}s:7:"summary";a:9:{s:10:"total_rows";i:3;s:11:"total_items";d:3;s:12:"total_weight";d:153;s:19:"total_reward_points";d:1395;s:18:"item_summary_total";d:139.43999999999999772626324556767940521240234375;s:14:"shipping_total";d:7.25;s:9:"tax_total";d:24.447999999999996845190253225155174732208251953125;s:15:"surcharge_total";d:0;s:5:"total";d:146.68999999999999772626324556767940521240234375;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"5";s:4:"name";s:28:"EU Zone 1: Standard Shipping";s:11:"description";s:8:"3-4 Days";s:5:"value";s:4:"7.25";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"2";s:7:"zone_id";s:1:"1";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:11:"France (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"2";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:11:"France (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:23.239999999999998436805981327779591083526611328125;s:12:"shipping_tax";d:1.2079999999999999626965063725947402417659759521484375;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";d:1.6668000000000091631591203622519969940185546875;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:22.78320000000000078443918027915060520172119140625;s:18:"cart_taxable_value";d:113.906800000000004047251422889530658721923828125;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:1:{s:13:"10-FIXED-RATE";a:3:{s:2:"id";s:1:"3";s:4:"code";s:13:"10-FIXED-RATE";s:11:"description";s:58:"Discount Code "10-FIXED-RATE" - &pound;10 off grand total.";}}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:1:{s:5:"total";a:5:{s:2:"id";s:1:"3";s:4:"code";s:13:"10-FIXED-RATE";s:11:"description";s:58:"Discount Code "10-FIXED-RATE" - &pound;10 off grand total.";s:9:"tax_value";d:1.6668000000000091631591203622519969940185546875;s:5:"value";d:10;}}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";d:10;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:5;s:12:"order_number";s:8:"00000005";}}}', '2017-06-13 13:59:56', 1),
(6, 1, 'a:3:{s:5:"items";a:3:{s:32:"5f93f983524def3dca464469d2cf9f3e";a:15:{s:6:"row_id";s:32:"5f93f983524def3dca464469d2cf9f3e";s:2:"id";i:110;s:4:"name";s:20:"Item #110, tax free.";s:8:"quantity";d:1;s:5:"price";d:109.5;s:14:"stock_quantity";b:0;s:14:"internal_price";d:109.5;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:0;}s:32:"c4ca4238a0b923820dcc509a6f75849b";a:15:{s:6:"row_id";s:32:"c4ca4238a0b923820dcc509a6f75849b";s:2:"id";s:1:"1";s:4:"name";s:24:"Example Database Item #1";s:8:"quantity";d:1;s:5:"price";d:25;s:6:"weight";d:75;s:14:"stock_quantity";s:3:"100";s:14:"internal_price";d:25;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:4.16669999999999962625452099018730223178863525390625;}s:32:"8e98d81f8217304975ccb23337bb5761";a:15:{s:6:"row_id";s:32:"8e98d81f8217304975ccb23337bb5761";s:2:"id";i:307;s:4:"name";s:64:"Discount Item #307, Buy 5 @ &pound;10.00, get 2 for &pound;7.00.";s:8:"quantity";d:7;s:5:"price";d:10;s:14:"stock_quantity";b:0;s:14:"internal_price";d:10;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.666700000000000070343730840249918401241302490234375;}}s:7:"summary";a:9:{s:10:"total_rows";i:3;s:11:"total_items";d:9;s:12:"total_weight";d:75;s:19:"total_reward_points";d:2045;s:18:"item_summary_total";d:204.5;s:14:"shipping_total";d:0;s:9:"tax_total";d:15.8300000000000000710542735760100185871124267578125;s:15:"surcharge_total";d:0;s:5:"total";d:204.5;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"4";s:4:"name";s:13:"UK Collection";s:11:"description";s:18:"Available Next Day";s:5:"value";s:4:"0.00";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:15.8333999999999992525090419803746044635772705078125;s:12:"shipping_tax";i:0;s:17:"item_discount_tax";d:1;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:14.8333999999999992525090419803746044635772705078125;s:18:"cart_taxable_value";d:74.1663999999999958845364744774997234344482421875;s:22:"cart_non_taxable_value";d:109.5;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:1:{s:32:"8e98d81f8217304975ccb23337bb5761";a:7:{s:2:"id";i:13;s:11:"description";s:64:"Discount Item #307, Buy 5 @ &pound;10.00, get 2 for &pound;7.00.";s:17:"discount_quantity";d:2;s:21:"non_discount_quantity";d:5;s:9:"tax_value";d:1.166700000000000070343730840249918401241302490234375;s:5:"value";d:3;s:17:"shipping_discount";b:0;}}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:6;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:6;s:12:"order_number";s:8:"00000006";}}}', '2017-06-16 11:26:36', 1),
(7, 1, 'a:3:{s:5:"items";a:2:{s:32:"f0935e4cd5920aa6c7c996a5ee53a70f";a:15:{s:6:"row_id";s:32:"f0935e4cd5920aa6c7c996a5ee53a70f";s:2:"id";i:106;s:4:"name";s:56:"Item #106, shipped separately from the rest of the cart.";s:8:"quantity";d:1;s:5:"price";d:18.28999999999999914734871708787977695465087890625;s:14:"stock_quantity";b:0;s:14:"internal_price";d:19.949999999999999289457264239899814128875732421875;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.66270000000000006679101716144941747188568115234375;}s:32:"38b3eff8baf56627478ec76a704e9b52";a:15:{s:6:"row_id";s:32:"38b3eff8baf56627478ec76a704e9b52";s:2:"id";i:101;s:4:"name";s:35:"Item #101, minimum required fields.";s:8:"quantity";d:1;s:5:"price";d:18.3299999999999982946974341757595539093017578125;s:14:"stock_quantity";b:0;s:14:"internal_price";d:20;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.6664000000000001033839680530945770442485809326171875;}}s:7:"summary";a:9:{s:10:"total_rows";i:2;s:11:"total_items";d:2;s:12:"total_weight";d:0;s:19:"total_reward_points";d:366;s:18:"item_summary_total";d:36.61999999999999744204615126363933086395263671875;s:14:"shipping_total";d:27.309999999999998721023075631819665431976318359375;s:9:"tax_total";d:5.8130000000000006110667527536861598491668701171875;s:15:"surcharge_total";d:0;s:5:"total";d:63.92999999999999971578290569595992565155029296875;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:2:"12";s:4:"name";s:22:"Australia NSW Shipping";s:11:"description";s:7:"10 Days";s:5:"value";s:5:"14.90";s:8:"tax_rate";N;s:8:"location";a:2:{i:0;a:5:{s:11:"location_id";s:2:"11";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:1:"8";s:4:"name";s:3:"NSW";}i:1;a:5:{s:11:"location_id";s:1:"8";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:9:"Australia";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";d:14.9000000000000003552713678800500929355621337890625;s:14:"separate_items";d:1;s:14:"separate_value";d:18.28999999999999914734871708787977695465087890625;s:15:"separate_weight";d:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:1:{i:0;s:32:"f0935e4cd5920aa6c7c996a5ee53a70f";}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"GST";s:4:"rate";s:7:"10.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:2:{i:0;a:5:{s:11:"location_id";s:2:"11";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"2";s:9:"parent_id";s:1:"8";s:4:"name";s:3:"NSW";}i:1;a:5:{s:11:"location_id";s:1:"8";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:9:"Australia";}}s:4:"data";a:9:{s:14:"item_total_tax";d:3.329099999999999948130380289512686431407928466796875;s:12:"shipping_tax";d:2.483000000000000095923269327613525092601776123046875;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:5.81210000000000004405364961712621152400970458984375;s:18:"cart_taxable_value";d:58.12089999999999889723767410032451152801513671875;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:7;s:12:"order_number";s:8:"00000007";}}}', '2017-06-19 08:53:16', 1),
(8, 1, 'a:3:{s:5:"items";a:3:{s:32:"274ad4786c3abca69fa097b85867d9a4";a:15:{s:6:"row_id";s:32:"274ad4786c3abca69fa097b85867d9a4";s:2:"id";s:3:"204";s:4:"name";s:40:"Item #204, added multiple items via form";s:8:"quantity";d:2;s:5:"price";d:16.120000000000001;s:14:"stock_quantity";b:0;s:14:"internal_price";d:18.25;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:0.91249999999999998;}s:32:"eae27d77ca20db309e056e3d2dcd7d69";a:15:{s:6:"row_id";s:32:"eae27d77ca20db309e056e3d2dcd7d69";s:2:"id";s:3:"205";s:4:"name";s:40:"Item #205, added multiple items via form";s:8:"quantity";d:1;s:5:"price";d:35.289999999999999;s:14:"stock_quantity";b:0;s:14:"internal_price";d:39.950000000000003;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:1.9975000000000001;}s:32:"a87ff679a2f3e71d9181a67b7542122c";a:15:{s:6:"row_id";s:32:"a87ff679a2f3e71d9181a67b7542122c";s:2:"id";s:1:"4";s:4:"name";s:24:"Example Database Item #4";s:8:"quantity";d:1;s:5:"price";d:176.66;s:6:"weight";d:250;s:14:"stock_quantity";s:2:"98";s:14:"internal_price";d:199.99000000000001;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:9.9995999999999992;}}s:7:"summary";a:9:{s:10:"total_rows";i:3;s:11:"total_items";d:4;s:12:"total_weight";d:250;s:19:"total_reward_points";d:2442;s:18:"item_summary_total";d:244.19;s:14:"shipping_total";d:12.800000000000001;s:9:"tax_total";d:14.5448;s:15:"surcharge_total";d:0;s:5:"total";d:256.99000000000001;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:2:"14";s:4:"name";s:37:"United States (Non CA or NY) Shipping";s:11:"description";s:6:"8 Days";s:5:"value";s:5:"14.50";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:2:"10";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"United States";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:14:"Tax (Other US)";s:4:"rate";s:6:"6.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:2:"10";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"United States";}}s:4:"data";a:9:{s:14:"item_total_tax";d:13.821999999999999;s:12:"shipping_tax";d:0.7248;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:14.546799999999999;s:18:"cart_taxable_value";d:242.4479;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:30:{s:2:"id";b:1;s:16:"pagination_limit";b:1;s:15:"user_file_limit";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:8;s:12:"order_number";s:8:"00000008";}}}', '2018-02-15 16:44:29', 1),
(9, 1, 'a:3:{s:5:"items";a:2:{s:32:"38b3eff8baf56627478ec76a704e9b52";a:15:{s:6:"row_id";s:32:"38b3eff8baf56627478ec76a704e9b52";s:2:"id";i:101;s:4:"name";s:35:"Item #101, minimum required fields.";s:8:"quantity";d:2;s:5:"price";d:20;s:14:"stock_quantity";b:0;s:14:"internal_price";d:20;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";s:23:"Example saved cart item";s:14:"status_message";a:0:{}s:3:"tax";d:3.333299999999999929656269159750081598758697509765625;}s:32:"757b505cfd34c64c85ca5b5690ee5293";a:15:{s:6:"row_id";s:32:"757b505cfd34c64c85ca5b5690ee5293";s:2:"id";s:3:"201";s:4:"name";s:25:"Item #201: added via form";s:8:"quantity";d:1;s:5:"price";d:59.9500000000000028421709430404007434844970703125;s:14:"stock_quantity";b:0;s:14:"internal_price";d:59.9500000000000028421709430404007434844970703125;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:9.9916999999999998038902049302123486995697021484375;}}s:7:"summary";a:9:{s:10:"total_rows";i:2;s:11:"total_items";d:3;s:12:"total_weight";d:0;s:19:"total_reward_points";d:1000;s:18:"item_summary_total";d:99.9500000000000028421709430404007434844970703125;s:14:"shipping_total";d:3.95000000000000017763568394002504646778106689453125;s:9:"tax_total";d:17.318000000000001392663762089796364307403564453125;s:15:"surcharge_total";d:0;s:5:"total";d:103.900000000000005684341886080801486968994140625;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"1";s:4:"name";s:20:"UK Standard Shipping";s:11:"description";s:8:"2-3 Days";s:5:"value";s:4:"3.95";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:16.658400000000000318323145620524883270263671875;s:12:"shipping_tax";d:0.65800000000000002930988785010413266718387603759765625;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:17.3164000000000015688783605583012104034423828125;s:18:"cart_taxable_value";d:86.58170000000001209627953357994556427001953125;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:9;s:12:"order_number";b:0;}}}', '2017-06-25 03:46:36', 0);
INSERT INTO `cart_data` (`cart_data_id`, `cart_data_user_fk`, `cart_data_array`, `cart_data_date`, `cart_data_readonly_status`) VALUES
(10, 1, 'a:3:{s:5:"items";a:3:{s:32:"966cc1c5d63213a34789e7064393f2e5";a:16:{s:6:"row_id";s:32:"966cc1c5d63213a34789e7064393f2e5";s:2:"id";s:3:"203";s:4:"name";s:45:"Item #203, added via form with priced options";s:8:"quantity";d:1;s:5:"price";d:19.449999999999999289457264239899814128875732421875;s:7:"options";s:9:"Option #2";s:14:"stock_quantity";b:0;s:14:"internal_price";d:19.449999999999999289457264239899814128875732421875;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";s:23:"Example saved cart item";s:14:"status_message";a:0:{}s:3:"tax";d:3.2416999999999998038902049302123486995697021484375;}s:32:"6974ce5ac660610b44d9b9fed0ff9548";a:15:{s:6:"row_id";s:32:"6974ce5ac660610b44d9b9fed0ff9548";s:2:"id";i:103;s:4:"name";s:25:"Item #103, free shipping.";s:8:"quantity";d:1;s:5:"price";d:19.949999999999999289457264239899814128875732421875;s:13:"shipping_rate";d:0;s:14:"stock_quantity";b:0;s:14:"internal_price";d:19.949999999999999289457264239899814128875732421875;s:6:"weight";i:0;s:8:"tax_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:3.32500000000000017763568394002504646778106689453125;}s:32:"c4ca4238a0b923820dcc509a6f75849b";a:15:{s:6:"row_id";s:32:"c4ca4238a0b923820dcc509a6f75849b";s:2:"id";s:1:"1";s:4:"name";s:24:"Example Database Item #1";s:8:"quantity";d:2;s:5:"price";d:25;s:6:"weight";d:75;s:14:"stock_quantity";s:2:"99";s:14:"internal_price";d:25;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:4.16669999999999962625452099018730223178863525390625;}}s:7:"summary";a:9:{s:10:"total_rows";i:3;s:11:"total_items";d:4;s:12:"total_weight";d:150;s:19:"total_reward_points";d:895;s:18:"item_summary_total";d:89.400000000000005684341886080801486968994140625;s:14:"shipping_total";d:7.75;s:9:"tax_total";d:16.19200000000000017053025658242404460906982421875;s:15:"surcharge_total";d:0;s:5:"total";d:97.150000000000005684341886080801486968994140625;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"7";s:4:"name";s:28:"EU Zone 2: Standard Shipping";s:11:"description";s:8:"4-6 Days";s:5:"value";s:4:"7.75";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"4";s:7:"zone_id";s:1:"2";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"Portugal (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";d:1;s:10:"free_value";d:19.949999999999999289457264239899814128875732421875;s:11:"free_weight";d:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:1:{s:32:"6974ce5ac660610b44d9b9fed0ff9548";d:0;}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"4";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:13:"Portugal (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:14.9000000000000003552713678800500929355621337890625;s:12:"shipping_tax";d:1.2920000000000000373034936274052597582340240478515625;s:17:"item_discount_tax";d:4.16669999999999962625452099018730223178863525390625;s:20:"summary_discount_tax";d:1.203699999999997771737980656325817108154296875;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:10.826299999999999812416717759333550930023193359375;s:18:"cart_taxable_value";d:54.11370000000000146656020660884678363800048828125;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:1:{s:10:"10-PERCENT";a:3:{s:2:"id";s:1:"2";s:4:"code";s:10:"10-PERCENT";s:11:"description";s:49:"Discount Code "10-PERCENT" - 10% off grand total.";}}s:6:"manual";a:0:{}s:12:"active_items";a:1:{s:32:"c4ca4238a0b923820dcc509a6f75849b";a:7:{s:2:"id";i:32;s:11:"description";s:18:"Buy 2, Get 1 Free.";s:17:"discount_quantity";d:1;s:21:"non_discount_quantity";d:1;s:9:"tax_value";d:0;s:5:"value";d:25;s:17:"shipping_discount";b:0;}}s:14:"active_summary";a:1:{s:5:"total";a:5:{s:2:"id";s:1:"2";s:4:"code";s:10:"10-PERCENT";s:11:"description";s:49:"Discount Code "10-PERCENT" - 10% off grand total.";s:9:"tax_value";d:1.203699999999997771737980656325817108154296875;s:5:"value";d:7.219999999999998863131622783839702606201171875;}}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:25;s:24:"summary_discount_savings";d:7.219999999999998863131622783839702606201171875;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:28:{s:2:"id";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:10;s:12:"order_number";b:0;}}}', '2017-06-28 08:09:56', 0),
(11, 0, 'a:3:{s:5:"items";a:1:{s:32:"c9c4cbc1cb0eac0ab40d96309e98bf40";a:17:{s:6:"row_id";s:32:"c9c4cbc1cb0eac0ab40d96309e98bf40";s:2:"id";s:1:"6";s:4:"name";s:37:"Floral Tea Length Vintage Swing Dress";s:5:"thumb";s:72:"http://localhost/dvee/assets/images/f9028d67ba18c83b5114e70265f1b6a7.jpg";s:8:"quantity";d:1;s:5:"price";d:4;s:6:"weight";d:490;s:7:"options";a:2:{s:5:"color";s:9:"Any color";s:4:"size";s:8:"Any size";}s:14:"stock_quantity";s:2:"22";s:14:"internal_price";d:4;s:8:"tax_rate";b:0;s:13:"shipping_rate";b:0;s:17:"separate_shipping";b:0;s:13:"reward_points";b:0;s:9:"user_note";N;s:14:"status_message";a:0:{}s:3:"tax";d:0.66669999999999996;}}s:7:"summary";a:9:{s:10:"total_rows";i:1;s:11:"total_items";d:1;s:12:"total_weight";d:490;s:19:"total_reward_points";d:40;s:18:"item_summary_total";d:4;s:14:"shipping_total";d:5.2599999999999998;s:9:"tax_total";d:1.546;s:15:"surcharge_total";d:0;s:5:"total";d:9.2599999999999998;}s:8:"settings";a:6:{s:8:"currency";a:7:{s:4:"name";s:3:"GBP";s:13:"exchange_rate";s:6:"1.0000";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";s:7:"default";a:5:{s:4:"name";s:3:"GBP";s:6:"symbol";s:7:"&pound;";s:13:"symbol_suffix";b:0;s:18:"thousand_separator";s:1:",";s:17:"decimal_separator";s:1:".";}}s:8:"shipping";a:7:{s:2:"id";s:1:"1";s:4:"name";s:20:"UK Standard Shipping";s:11:"description";s:8:"2-3 Days";s:5:"value";s:4:"5.25";s:8:"tax_rate";N;s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"0";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:11:{s:9:"surcharge";d:0;s:23:"separate_shipping_value";i:0;s:14:"separate_items";i:0;s:14:"separate_value";i:0;s:15:"separate_weight";i:0;s:10:"free_items";i:0;s:10:"free_value";i:0;s:11:"free_weight";i:0;s:21:"banned_shipping_items";a:0:{}s:23:"separate_shipping_items";a:0:{}s:19:"item_shipping_rates";a:0:{}}}s:3:"tax";a:5:{s:4:"name";s:3:"VAT";s:4:"rate";s:7:"20.0000";s:13:"internal_rate";s:7:"20.0000";s:8:"location";a:1:{i:0;a:5:{s:11:"location_id";s:1:"1";s:7:"zone_id";s:1:"4";s:7:"type_id";s:1:"1";s:9:"parent_id";s:1:"0";s:4:"name";s:19:"United Kingdom (EU)";}}s:4:"data";a:9:{s:14:"item_total_tax";d:0.66669999999999996;s:12:"shipping_tax";d:0.876;s:17:"item_discount_tax";d:0;s:20:"summary_discount_tax";i:0;s:18:"reward_voucher_tax";i:0;s:13:"surcharge_tax";i:0;s:8:"cart_tax";d:1.5427;s:18:"cart_taxable_value";d:7.7133000000000003;s:22:"cart_non_taxable_value";d:0;}}s:9:"discounts";a:6:{s:5:"codes";a:0:{}s:6:"manual";a:0:{}s:12:"active_items";a:0:{}s:14:"active_summary";a:0:{}s:15:"reward_vouchers";a:0:{}s:4:"data";a:5:{s:21:"item_discount_savings";d:0;s:24:"summary_discount_savings";i:0;s:15:"reward_vouchers";i:0;s:23:"void_reward_point_items";a:0:{}s:18:"excluded_discounts";a:0:{}}}s:10:"surcharges";a:0:{}s:13:"configuration";a:30:{s:2:"id";b:1;s:16:"pagination_limit";b:1;s:15:"user_file_limit";b:1;s:19:"order_number_prefix";s:0:"";s:19:"order_number_suffix";s:0:"";s:22:"increment_order_number";b:1;s:13:"minimum_order";s:1:"0";s:17:"quantity_decimals";s:1:"0";s:33:"increment_duplicate_item_quantity";b:1;s:25:"quantity_limited_by_stock";b:1;s:21:"remove_no_stock_items";b:0;s:19:"auto_allocate_stock";b:1;s:26:"save_banned_shipping_items";b:0;s:11:"weight_type";s:4:"gram";s:15:"weight_decimals";s:1:"0";s:18:"display_tax_prices";b:1;s:13:"price_inc_tax";b:1;s:25:"multi_row_duplicate_items";b:0;s:21:"dynamic_reward_points";b:1;s:23:"reward_point_multiplier";s:7:"10.0000";s:25:"reward_voucher_multiplier";s:6:"0.0100";s:29:"reward_point_to_voucher_ratio";s:3:"250";s:25:"reward_point_days_pending";s:2:"14";s:23:"reward_point_days_valid";s:3:"365";s:25:"reward_voucher_days_valid";s:3:"365";s:15:"custom_status_1";b:0;s:15:"custom_status_2";b:0;s:15:"custom_status_3";b:0;s:12:"cart_data_id";i:11;s:12:"order_number";s:17:"409816815N902352C";}}}', '2017-06-30 22:36:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `curr_id` smallint(5) NOT NULL,
  `curr_name` varchar(50) NOT NULL DEFAULT '',
  `curr_exchange_rate` double(8,4) NOT NULL DEFAULT '0.0000',
  `curr_symbol` varchar(25) NOT NULL DEFAULT '',
  `curr_symbol_suffix` tinyint(1) NOT NULL DEFAULT '0',
  `curr_thousand_separator` varchar(10) NOT NULL DEFAULT '',
  `curr_decimal_separator` varchar(10) NOT NULL DEFAULT '',
  `curr_status` tinyint(1) NOT NULL DEFAULT '0',
  `curr_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`curr_id`, `curr_name`, `curr_exchange_rate`, `curr_symbol`, `curr_symbol_suffix`, `curr_thousand_separator`, `curr_decimal_separator`, `curr_status`, `curr_default`) VALUES
(1, 'AUD', 2.0000, 'AU $', 0, ',', '.', 1, 0),
(2, 'EUR', 1.1500, '&euro;', 1, '.', ',', 1, 0),
(3, 'GBP', 1.0000, '&pound;', 0, ',', '.', 1, 1),
(4, 'USD', 1.6000, 'US $', 0, ',', '.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `disc_id` int(11) NOT NULL,
  `disc_type_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_method_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_tax_method_fk` tinyint(1) NOT NULL DEFAULT '0',
  `disc_user_acc_fk` int(11) NOT NULL DEFAULT '0',
  `disc_item_fk` int(11) NOT NULL DEFAULT '0' COMMENT 'Item / Product Id',
  `disc_group_fk` int(11) NOT NULL DEFAULT '0',
  `disc_location_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_code` varchar(50) NOT NULL DEFAULT '' COMMENT 'Discount Code',
  `disc_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name shown in cart when active',
  `disc_quantity_required` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Quantity required for offer',
  `disc_quantity_discounted` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Quantity affected by offer',
  `disc_value_required` double(8,2) NOT NULL DEFAULT '0.00',
  `disc_value_discounted` double(8,2) NOT NULL DEFAULT '0.00' COMMENT '% discount, flat fee discount, new set price - specified via calculation_fk',
  `disc_recursive` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Discount is repeatable multiple times on one item',
  `disc_non_combinable_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cannot be applied if any other discount is applied',
  `disc_void_reward_points` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Voids any current reward points',
  `disc_force_ship_discount` tinyint(1) NOT NULL DEFAULT '0',
  `disc_custom_status_1` varchar(50) NOT NULL DEFAULT '',
  `disc_custom_status_2` varchar(50) NOT NULL DEFAULT '',
  `disc_custom_status_3` varchar(50) NOT NULL DEFAULT '',
  `disc_usage_limit` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Number of offers available',
  `disc_valid_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `disc_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `disc_status` tinyint(1) NOT NULL DEFAULT '0',
  `disc_order_by` smallint(1) NOT NULL DEFAULT '100' COMMENT 'Default value of 100 to ensure non set ''order by'' values of zero are not before 1,2,3 etc.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`disc_id`, `disc_type_fk`, `disc_method_fk`, `disc_tax_method_fk`, `disc_user_acc_fk`, `disc_item_fk`, `disc_group_fk`, `disc_location_fk`, `disc_zone_fk`, `disc_code`, `disc_description`, `disc_quantity_required`, `disc_quantity_discounted`, `disc_value_required`, `disc_value_discounted`, `disc_recursive`, `disc_non_combinable_discount`, `disc_void_reward_points`, `disc_force_ship_discount`, `disc_custom_status_1`, `disc_custom_status_2`, `disc_custom_status_3`, `disc_usage_limit`, `disc_valid_date`, `disc_expire_date`, `disc_status`, `disc_order_by`) VALUES
(1, 1, 11, 1, 0, 0, 0, 1, 0, 'FREE-UK-SHIPPING', 'Discount Code "FREE-UK-SHIPPING" - Free UK shipping.', 0, 0, 0.00, 0.00, 0, 0, 1, 1, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(2, 2, 12, 1, 0, 0, 0, 0, 0, '10-PERCENT', 'Discount Code "10-PERCENT" - 10% off grand total.', 0, 0, 0.00, 10.00, 0, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(3, 2, 13, 1, 0, 0, 0, 0, 0, '10-FIXED-RATE', 'Discount Code "10-FIXED-RATE" - &pound;10 off grand total.', 0, 0, 0.00, 10.00, 0, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(4, 2, 13, 1, 0, 0, 0, 0, 0, '', 'Discount Summary, Spend over &pound;1,000, get &pound;100 off.', 1, 1, 1000.00, 100.00, 0, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(5, 2, 11, 1, 0, 0, 0, 0, 0, '', 'Discount Summary, Spend over &pound;500, get free worldwide shipping.', 0, 0, 500.00, 0.00, 0, 0, 0, 1, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(6, 2, 12, 1, 0, 0, 0, 0, 0, '', 'Discount Summary, Logged in users get 5% off total.', 0, 0, 0.00, 5.00, 0, 0, 0, 0, '1', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(7, 1, 1, 1, 0, 301, 0, 0, 0, '', 'Discount Item #301, 10% off original price (&pound;24.99).', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9997, '2017-06-30 22:39:58', '2017-08-30 22:39:58', 1, 1),
(8, 1, 2, 1, 0, 302, 0, 0, 0, '', 'Discount Item #302, Fixed price of &pound;5.00 off original price of &pound;12.50.', 1, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(9, 1, 3, 1, 0, 303, 0, 0, 0, '', 'Discount Item #303, New price of &pound;15.00, item was &pound;25.00.', 1, 1, 0.00, 15.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(10, 1, 3, 1, 0, 304, 0, 0, 0, '', 'Discount Item #304, Buy 2, get 1 free.', 3, 1, 0.00, 0.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(11, 1, 1, 1, 0, 305, 0, 0, 0, '', 'Discount Item #305, Buy 1, get 1 @ 50% off.', 2, 1, 0.00, 50.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(12, 1, 2, 1, 0, 306, 0, 0, 0, '', 'Discount Item #306, Buy 2 @ &pound;15.00, get 1 with &pound;5.00 off.', 3, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(13, 1, 3, 1, 0, 307, 0, 0, 0, '', 'Discount Item #307, Buy 5 @ &pound;10.00, get 2 for &pound;7.00.', 7, 2, 0.00, 7.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(14, 1, 6, 1, 0, 308, 0, 1, 0, '', 'Discount Item #308, Buy 3, get free UK shipping on these items (Other items still charged).', 3, 3, 0.00, 0.00, 1, 0, 0, 1, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(15, 1, 1, 1, 0, 309, 0, 0, 0, '', 'Discount Item #309, Spend over &pound;75.00 on this item, get 10% off this items total.', 1, 1, 75.00, 10.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(16, 1, 2, 1, 0, 310, 0, 0, 0, '', 'Discount Item #310, Spend over &pound;100.00 on this item, get &pound;10.00 off this items total.', 1, 1, 100.00, 10.00, 0, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(17, 1, 3, 1, 0, 0, 1, 0, 0, '', 'Discount Group: Discount Items #311, #312 and #313 - buy 3, get cheapest item free.', 3, 1, 0.00, 0.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(18, 1, 1, 1, 0, 314, 0, 0, 0, '', 'Discount Item #314, 10% off original price - but for logged in users only.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '1', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(19, 1, 1, 1, 0, 315, 0, 0, 0, '', 'Discount Item #315, 10% off original price - but removes the items reward points (Normally 200 points).', 1, 1, 0.00, 10.00, 1, 0, 1, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(20, 1, 1, 1, 0, 316, 0, 0, 0, '', 'Discount Item #316, 10% off original price - but applies to first item only (Non recursive quantity discount).', 1, 1, 0.00, 10.00, 0, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(21, 1, 1, 1, 0, 317, 0, 1, 0, '', 'Discount Item #317, 10% off original price - but applies to orders being shipped to the UK only.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(22, 1, 1, 1, 0, 318, 0, 0, 0, '', 'Discount Item #318, 10% off original price - but cannot be applied if other discounts exist.', 1, 1, 0.00, 10.00, 1, 1, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(23, 1, 1, 1, 0, 401, 0, 0, 0, '', 'Discount Tax #401, get 10% off original price (&pound;10.00) - Method #1.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(24, 1, 1, 2, 0, 402, 0, 0, 0, '', 'Discount Tax #402, get 10% off original price (&pound;10.00) - Method #2.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(25, 1, 1, 3, 0, 403, 0, 0, 0, '', 'Discount Tax #403, get 10% off original price (&pound;10.00) - Method #3.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(26, 1, 2, 1, 0, 404, 0, 0, 0, '', 'Discount Tax #404, get set price of (&pound;5.00) off original price (&pound;10.00) - Method #1.', 1, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(27, 1, 2, 2, 0, 405, 0, 0, 0, '', 'Discount Tax #405, get set price of (&pound;5.00) off original price (&pound;10.00) - Method #2.', 1, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(28, 1, 2, 3, 0, 406, 0, 0, 0, '', 'Discount Tax #406, get set price of (&pound;5.00) off original price (&pound;10.00) - Method #3.', 1, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(29, 1, 3, 1, 0, 407, 0, 0, 0, '', 'Discount Tax #407, get for new price of &pound;7.50 (Original price &pound;10.00) - Method #1.', 1, 1, 0.00, 7.50, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(30, 1, 3, 2, 0, 408, 0, 0, 0, '', 'Discount Tax #408, get for new price of &pound;7.50 (Original price &pound;10.00) - Method #2.', 1, 1, 0.00, 7.50, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(31, 1, 3, 3, 0, 409, 0, 0, 0, '', 'Discount Tax #409, get for new price of &pound;7.50 (Original price &pound;10.00) - Method #3.', 1, 1, 0.00, 7.50, 1, 0, 0, 0, '', '', '', 9999, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 1),
(32, 1, 3, 0, 0, 1, 0, 0, 0, '', 'Database Item #1: Buy 2, Get 1 Free.', 2, 1, 0.00, 0.00, 1, 0, 0, 0, '', '', '', 9, '2017-06-28 22:39:58', '2017-07-28 22:39:58', 1, 1),
(33, 1, 1, 0, 0, 3, 0, 0, 0, '', 'Database Item #3: 10% off original price.', 1, 1, 0.00, 10.00, 1, 0, 0, 0, '', '', '', 9, '2017-06-28 22:39:58', '2017-07-24 22:39:58', 1, 1),
(34, 1, 2, 0, 0, 5, 0, 0, 0, '', 'Database Item #5: Get &pound;5.00 off original price.', 1, 1, 0.00, 5.00, 1, 0, 0, 0, '', '', '', 10, '2017-06-28 22:39:58', '2017-07-21 22:39:58', 1, 1),
(35, 3, 14, 0, 1, 0, 0, 0, 0, '2AC2AE9AEF923F4', 'Reward Voucher: 2AC2AE9AEF923F4', 0, 0, 0.00, 5.00, 0, 0, 1, 0, '', '', '', 1, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 100),
(36, 3, 14, 0, 4, 0, 0, 0, 0, '088F148041B66A9', 'Reward Voucher: 088F148041B66A9', 0, 0, 0.00, 10.00, 0, 0, 1, 0, '', '', '', 0, '2017-06-28 22:39:58', '2017-08-30 22:39:58', 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `discount_calculation`
--

CREATE TABLE `discount_calculation` (
  `disc_calculation_id` smallint(5) NOT NULL,
  `disc_calculation` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Note: Do not alter the order or id''s of records in table.';

--
-- Dumping data for table `discount_calculation`
--

INSERT INTO `discount_calculation` (`disc_calculation_id`, `disc_calculation`) VALUES
(1, 'Percentage Based'),
(2, 'Flat Fee'),
(3, 'New Value');

-- --------------------------------------------------------

--
-- Table structure for table `discount_columns`
--

CREATE TABLE `discount_columns` (
  `disc_column_id` smallint(5) NOT NULL,
  `disc_column` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Note: Do not alter the order or id''s of records in table.';

--
-- Dumping data for table `discount_columns`
--

INSERT INTO `discount_columns` (`disc_column_id`, `disc_column`) VALUES
(1, 'Item Price'),
(2, 'Item Shipping'),
(3, 'Summary Item Total'),
(4, 'Summary Shipping Total'),
(5, 'Summary Total'),
(6, 'Summary Total (Voucher)');

-- --------------------------------------------------------

--
-- Table structure for table `discount_groups`
--

CREATE TABLE `discount_groups` (
  `disc_group_id` smallint(5) NOT NULL,
  `disc_group` varchar(255) NOT NULL DEFAULT '',
  `disc_group_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discount_groups`
--

INSERT INTO `discount_groups` (`disc_group_id`, `disc_group`, `disc_group_status`) VALUES
(1, 'Demo Group : Items #311, #312 and #313', 1);

-- --------------------------------------------------------

--
-- Table structure for table `discount_group_items`
--

CREATE TABLE `discount_group_items` (
  `disc_group_item_id` int(11) NOT NULL,
  `disc_group_item_group_fk` int(11) NOT NULL DEFAULT '0',
  `disc_group_item_item_fk` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discount_group_items`
--

INSERT INTO `discount_group_items` (`disc_group_item_id`, `disc_group_item_group_fk`, `disc_group_item_item_fk`) VALUES
(1, 1, 311),
(2, 1, 312),
(3, 1, 313);

-- --------------------------------------------------------

--
-- Table structure for table `discount_methods`
--

CREATE TABLE `discount_methods` (
  `disc_method_id` smallint(5) NOT NULL COMMENT 'Note: Do not alter the order or id''s of records in table.',
  `disc_method_type_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_method_column_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_method_calculation_fk` smallint(5) NOT NULL DEFAULT '0',
  `disc_method` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount_methods`
--

INSERT INTO `discount_methods` (`disc_method_id`, `disc_method_type_fk`, `disc_method_column_fk`, `disc_method_calculation_fk`, `disc_method`) VALUES
(1, 1, 1, 1, 'Item Price - Percentage Based'),
(2, 1, 1, 2, 'Item Price - Flat Fee'),
(3, 1, 1, 3, 'Item Price - New Value'),
(4, 1, 2, 1, 'Item Shipping - Percentage Based'),
(5, 1, 2, 2, 'Item Shipping - Flat Fee'),
(6, 1, 2, 3, 'Item Shipping - New Value'),
(7, 2, 3, 1, 'Summary Item Total - Percentage Based'),
(8, 2, 3, 2, 'Summary Item Total - Flat Fee'),
(9, 2, 4, 1, 'Summary Shipping Total - Percentage Based'),
(10, 2, 4, 2, 'Summary Shipping Total - Flat Fee'),
(11, 2, 4, 3, 'Summary Shipping Total - New Value'),
(12, 2, 5, 1, 'Summary Total - Percentage Based'),
(13, 2, 5, 2, 'Summary Total - Flat Fee'),
(14, 3, 6, 2, 'Summary Total - Flat Fee (Voucher)');

-- --------------------------------------------------------

--
-- Table structure for table `discount_tax_methods`
--

CREATE TABLE `discount_tax_methods` (
  `disc_tax_method_id` smallint(5) NOT NULL,
  `disc_tax_method` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Note: Do not alter the order or id''s of records in table.';

--
-- Dumping data for table `discount_tax_methods`
--

INSERT INTO `discount_tax_methods` (`disc_tax_method_id`, `disc_tax_method`) VALUES
(1, 'Apply Tax Before Discount '),
(2, 'Apply Discount Before Tax'),
(3, 'Apply Discount Before Tax, Add Original Tax');

-- --------------------------------------------------------

--
-- Table structure for table `discount_types`
--

CREATE TABLE `discount_types` (
  `disc_type_id` smallint(5) NOT NULL,
  `disc_type` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Note: Do not alter the order or id''s of records in table.';

--
-- Dumping data for table `discount_types`
--

INSERT INTO `discount_types` (`disc_type_id`, `disc_type`) VALUES
(1, 'Item Discount'),
(2, 'Summary Discount'),
(3, 'Reward Voucher');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE `item_stock` (
  `stock_id` int(11) NOT NULL,
  `stock_item_fk` int(11) NOT NULL DEFAULT '0',
  `stock_quantity` smallint(5) NOT NULL DEFAULT '0',
  `stock_auto_allocate_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`stock_id`, `stock_item_fk`, `stock_quantity`, `stock_auto_allocate_status`) VALUES
(11, 2, 100, 0),
(12, 3, 17, 0),
(13, 28, 32, 0),
(14, 26, 86, 0),
(15, 30, 34, 0),
(16, 31, 85, 0),
(17, 33, 24, 0),
(18, 4, 98, 0),
(19, 24, 67, 0),
(20, 5, 32, 0),
(21, 6, 22, 0),
(22, 7, 1, 0),
(23, 9, 5, 0),
(25, 10, 47, 0),
(26, 25, 56, 0),
(27, 23, 68, 0),
(28, 11, 14, 0),
(34, 17, 35, 0),
(35, 18, 13, 0),
(36, 19, 34, 0),
(37, 20, 77, 0),
(38, 21, 45, 0),
(39, 22, 12, 0),
(40, 34, 38, 0),
(41, 27, 48, 0),
(42, 29, 6, 0),
(43, 38, 2, 1),
(45, 32, 45, 0),
(47, 25, 56, 0),
(48, 23, 68, 0),
(51, 12, 6, 0),
(52, 13, 64, 0),
(53, 14, 13, 0),
(54, 15, 76, 0),
(55, 16, 67, 0);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `loc_id` int(11) NOT NULL,
  `loc_type_fk` smallint(5) NOT NULL DEFAULT '0',
  `loc_parent_fk` int(11) NOT NULL DEFAULT '0',
  `loc_ship_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `loc_tax_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `loc_name` varchar(50) NOT NULL DEFAULT '',
  `loc_status` tinyint(1) NOT NULL DEFAULT '0',
  `loc_ship_default` tinyint(1) NOT NULL DEFAULT '0',
  `loc_tax_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`loc_id`, `loc_type_fk`, `loc_parent_fk`, `loc_ship_zone_fk`, `loc_tax_zone_fk`, `loc_name`, `loc_status`, `loc_ship_default`, `loc_tax_default`) VALUES
(1, 1, 0, 0, 4, 'United Kingdom (EU)', 1, 1, 1),
(2, 1, 0, 1, 4, 'France (EU)', 1, 0, 0),
(3, 1, 0, 1, 4, 'Germany (EU)', 1, 0, 0),
(4, 1, 0, 2, 4, 'Portugal (EU)', 1, 0, 0),
(5, 1, 0, 2, 4, 'Spain (EU)', 1, 0, 0),
(6, 1, 0, 3, 5, 'Norway (Non EU)', 1, 0, 0),
(7, 1, 0, 3, 5, 'Switzerland (Non EU)', 1, 0, 0),
(8, 1, 0, 0, 0, 'Australia', 1, 0, 0),
(9, 1, 0, 0, 0, 'Canada', 1, 0, 0),
(10, 1, 0, 0, 0, 'United States', 1, 0, 0),
(11, 2, 8, 0, 0, 'NSW', 1, 0, 0),
(12, 2, 8, 0, 0, 'Queensland', 1, 0, 0),
(13, 2, 8, 0, 0, 'Victoria', 1, 0, 0),
(14, 2, 10, 0, 0, 'California', 1, 0, 0),
(15, 2, 10, 0, 0, 'Florida', 1, 0, 0),
(16, 2, 10, 0, 0, 'New York', 1, 0, 0),
(17, 2, 10, 0, 0, 'Pennsylvania', 1, 0, 0),
(18, 3, 16, 0, 0, '10101', 1, 0, 0),
(19, 3, 16, 0, 0, '10102', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `location_type`
--

CREATE TABLE `location_type` (
  `loc_type_id` smallint(5) NOT NULL,
  `loc_type_parent_fk` smallint(5) NOT NULL DEFAULT '0',
  `loc_type_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_type`
--

INSERT INTO `location_type` (`loc_type_id`, `loc_type_parent_fk`, `loc_type_name`) VALUES
(1, 0, 'Country'),
(2, 1, 'State'),
(3, 2, 'Post / Zip Code');

-- --------------------------------------------------------

--
-- Table structure for table `location_zones`
--

CREATE TABLE `location_zones` (
  `lzone_id` smallint(5) NOT NULL,
  `lzone_name` varchar(50) NOT NULL DEFAULT '',
  `lzone_description` longtext NOT NULL,
  `lzone_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_zones`
--

INSERT INTO `location_zones` (`lzone_id`, `lzone_name`, `lzone_description`, `lzone_status`) VALUES
(1, 'Shipping Europe Zone 1', 'Example Zone 1 includes France and Germany', 1),
(2, 'Shipping Europe Zone 2', 'Example Zone 2 includes Portugal and Spain', 1),
(3, 'Shipping Europe Zone 3', 'Example Zone 3 includes Norway and Switzerland', 1),
(4, 'Tax EU Zone', 'Example Tax Zone for EU countries', 1),
(5, 'Tax Non EU Zone', 'Example Tax Zone for Non EU European countries', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(20170609020401);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `ord_det_id` int(11) NOT NULL,
  `ord_det_order_number_fk` varchar(25) NOT NULL DEFAULT '',
  `ord_det_cart_row_id` varchar(32) NOT NULL DEFAULT '',
  `ord_det_item_fk` int(11) NOT NULL DEFAULT '0',
  `ord_det_item_name` varchar(255) NOT NULL DEFAULT '',
  `ord_det_item_option` varchar(255) NOT NULL DEFAULT '',
  `ord_det_quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_non_discount_quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_discount_quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_stock_quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_price` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_price_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_discount_price` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_discount_price_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_discount_description` varchar(255) NOT NULL DEFAULT '',
  `ord_det_tax_rate` double(8,4) NOT NULL DEFAULT '0.0000',
  `ord_det_tax` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_tax_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_shipping_rate` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_weight` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_weight_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_reward_points` int(10) NOT NULL DEFAULT '0',
  `ord_det_reward_points_total` int(10) NOT NULL DEFAULT '0',
  `ord_det_status_message` varchar(255) NOT NULL DEFAULT '',
  `ord_det_quantity_shipped` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_quantity_cancelled` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_det_shipped_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ord_det_demo_user_note` varchar(255) NOT NULL DEFAULT '',
  `ord_det_demo_sku` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`ord_det_id`, `ord_det_order_number_fk`, `ord_det_cart_row_id`, `ord_det_item_fk`, `ord_det_item_name`, `ord_det_item_option`, `ord_det_quantity`, `ord_det_non_discount_quantity`, `ord_det_discount_quantity`, `ord_det_stock_quantity`, `ord_det_price`, `ord_det_price_total`, `ord_det_discount_price`, `ord_det_discount_price_total`, `ord_det_discount_description`, `ord_det_tax_rate`, `ord_det_tax`, `ord_det_tax_total`, `ord_det_shipping_rate`, `ord_det_weight`, `ord_det_weight_total`, `ord_det_reward_points`, `ord_det_reward_points_total`, `ord_det_status_message`, `ord_det_quantity_shipped`, `ord_det_quantity_cancelled`, `ord_det_shipped_date`, `ord_det_demo_user_note`, `ord_det_demo_sku`) VALUES
(1, '00000001', '38b3eff8baf56627478ec76a704e9b52', 101, 'Item #101, minimum required fields.', '', 1.00, 1.00, 0.00, 0.00, 20.00, 20.00, 20.00, 20.00, '', 20.0000, 3.33, 3.33, 0.00, 0.00, 0.00, 200, 200, '', 1.00, 0.00, '2017-06-14 03:53:23', '', ''),
(2, '00000002', '62b3e8cbab25f7c393a0996f39d4a9f6', 202, 'Item #202, added via form with options', 'Colour: Blue1Size: Medium', 2.00, 2.00, 0.00, 0.00, 27.50, 55.00, 27.50, 55.00, '', 20.0000, 4.58, 9.16, 0.00, 0.00, 0.00, 275, 550, '', 2.00, 0.00, '2017-06-16 11:26:43', '', ''),
(3, '00000002', '6974ce5ac660610b44d9b9fed0ff9548', 103, 'Item #103, free shipping.', '', 1.00, 1.00, 0.00, 0.00, 19.95, 19.95, 19.95, 19.95, '', 20.0000, 3.33, 3.33, 0.00, 0.00, 0.00, 200, 200, '', 1.00, 0.00, '0000-00-00 00:00:00', '', ''),
(4, '00000003', '0768281a05da9f27df178b5c39a51263', 1021, 'Item #1021, multiple items at once.', '', 1.00, 1.00, 0.00, 0.00, 20.63, 20.63, 20.63, 20.63, '', 10.0000, 1.88, 1.88, 0.00, 0.00, 0.00, 206, 206, '', 1.00, 0.00, '2017-03-01 10:00:03', '', ''),
(5, '00000003', '93d65641ff3f1586614cf2c1ad240b6c', 1022, 'Item #1022, multiple items at once.', '', 2.00, 2.00, 0.00, 0.00, 32.95, 65.90, 32.95, 65.90, '', 10.0000, 3.00, 6.00, 0.00, 0.00, 0.00, 330, 660, '', 2.00, 0.00, '2017-03-02 13:46:43', '', ''),
(6, '00000003', 'ce5140df15d046a66883807d18d0264b', 1023, 'Item #1023, multiple items at once.', '', 1.00, 1.00, 0.00, 0.00, 14.67, 14.67, 14.67, 14.67, '', 10.0000, 1.33, 1.33, 0.00, 0.00, 0.00, 147, 147, '', 0.00, 1.00, '0000-00-00 00:00:00', '', ''),
(7, '00000003', '7f6ffaa6bb0b408017b62254211691b5', 112, 'Item #112, stock controlled, in-stock.', '', 1.00, 1.00, 0.00, 20.00, 15.57, 15.57, 15.57, 15.57, '', 10.0000, 1.42, 1.42, 0.00, 0.00, 0.00, 156, 156, '', 1.00, 0.00, '2017-03-02 13:46:43', '', ''),
(8, '00000004', '37bc2f75bf1bcfe8450a1a41c200364c', 304, 'Discount Item #304, Buy 2, get 1 free.', '', 3.00, 2.00, 1.00, 0.00, 9.03, 27.09, 0.00, 18.06, 'Discount Item #304, Buy 2, get 1 free.', 8.3700, 0.70, 2.10, 0.00, 0.00, 0.00, 90, 270, '', 3.00, 0.00, '2017-06-19 22:46:43', '', ''),
(9, '00000005', 'c81e728d9d4c2f636f067f89cc14862c', 2, 'Example Database Item #2', '', 1.00, 1.00, 0.00, 100.00, 4.95, 4.95, 4.95, 4.95, '', 20.0000, 0.83, 0.83, 0.00, 15.00, 15.00, 50, 50, '', 1.00, 0.00, '2017-06-20 01:33:23', '', ''),
(10, '00000005', '8ba32330170ca729c650f411edf3777e', 115, 'Item #115, options.', 'Option Type #1: Option #11Option Type #2: Option #2', 1.00, 1.00, 0.00, 0.00, 79.49, 79.49, 79.49, 79.49, '', 20.0000, 13.25, 13.25, 0.00, 0.00, 0.00, 795, 795, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(11, '00000005', '2723d092b63885e0d7c260cc007e8b9d', 109, 'Item #109, defined weight.', '', 1.00, 1.00, 0.00, 0.00, 55.00, 55.00, 55.00, 55.00, '', 20.0000, 9.17, 9.17, 0.00, 138.00, 138.00, 550, 550, '', 1.00, 0.00, '2017-06-19 22:46:43', '', ''),
(12, '00000006', '5f93f983524def3dca464469d2cf9f3e', 110, 'Item #110, tax free.', '', 1.00, 1.00, 0.00, 0.00, 109.50, 109.50, 109.50, 109.50, '', 20.0000, 0.00, 0.00, 0.00, 0.00, 0.00, 1095, 1095, '', 1.00, 0.00, '0000-00-00 00:00:00', '', ''),
(13, '00000006', 'c4ca4238a0b923820dcc509a6f75849b', 1, 'Example Database Item #1', '', 1.00, 1.00, 0.00, 100.00, 25.00, 25.00, 25.00, 25.00, '', 20.0000, 4.17, 4.17, 0.00, 75.00, 75.00, 250, 250, '', 0.00, 1.00, '2017-06-22 06:20:03', '', ''),
(14, '00000006', '8e98d81f8217304975ccb23337bb5761', 307, 'Discount Item #307, Buy 5 @ &pound;10.00, get 2 for &pound;7.00.', '', 7.00, 5.00, 2.00, 0.00, 10.00, 70.00, 7.00, 64.00, 'Discount Item #307, Buy 5 @ &pound;10.00, get 2 for &pound;7.00.', 20.0000, 1.67, 11.69, 0.00, 0.00, 0.00, 100, 700, '', 7.00, 0.00, '0000-00-00 00:00:00', '', ''),
(15, '00000007', 'f0935e4cd5920aa6c7c996a5ee53a70f', 106, 'Item #106, shipped separately from the rest of the cart.', '', 1.00, 1.00, 0.00, 0.00, 18.29, 18.29, 18.29, 18.29, '', 10.0000, 1.66, 1.66, 0.00, 0.00, 0.00, 183, 183, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(16, '00000007', '38b3eff8baf56627478ec76a704e9b52', 101, 'Item #101, minimum required fields.', '', 1.00, 1.00, 0.00, 0.00, 18.33, 18.33, 18.33, 18.33, '', 10.0000, 1.67, 1.67, 0.00, 0.00, 0.00, 183, 183, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(17, '00000008', '274ad4786c3abca69fa097b85867d9a4', 204, 'Item #204, added multiple items via form', '', 2.00, 2.00, 0.00, 0.00, 16.12, 32.24, 16.12, 32.24, '', 6.0000, 0.91, 1.82, 0.00, 0.00, 0.00, 161, 322, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(18, '00000008', 'eae27d77ca20db309e056e3d2dcd7d69', 205, 'Item #205, added multiple items via form', '', 1.00, 1.00, 0.00, 0.00, 35.29, 35.29, 35.29, 35.29, '', 6.0000, 2.00, 2.00, 0.00, 0.00, 0.00, 353, 353, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(19, '00000008', 'a87ff679a2f3e71d9181a67b7542122c', 4, 'Example Database Item #4', '', 1.00, 1.00, 0.00, 98.00, 176.66, 176.66, 176.66, 176.66, '', 6.0000, 10.00, 10.00, 0.00, 250.00, 250.00, 1767, 1767, '', 0.00, 0.00, '0000-00-00 00:00:00', '', ''),
(20, '00000004', 'c4ca4238a0b923820dcc509a6f75849b', 1, 'Example Database Item #1', '', 1.00, 1.00, 0.00, 100.00, 22.58, 22.58, 22.58, 22.58, '', 8.3700, 1.74, 1.74, 0.00, 75.00, 75.00, 226, 226, '', 1.00, 0.00, '2017-06-20 01:33:23', '', ''),
(21, '409816815N902352C', 'c9c4cbc1cb0eac0ab40d96309e98bf40', 6, 'Floral Tea Length Vintage Swing Dress', 'color: Any color1size: Any size', 1.00, 1.00, 0.00, 22.00, 4.00, 4.00, 4.00, 4.00, '', 20.0000, 0.67, 0.67, 0.00, 490.00, 490.00, 40, 40, '', 0.00, 0.00, '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `ord_status_id` smallint(5) NOT NULL,
  `ord_status_description` varchar(50) NOT NULL DEFAULT '',
  `ord_status_cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `ord_status_save_default` tinyint(1) NOT NULL DEFAULT '0',
  `ord_status_resave_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`ord_status_id`, `ord_status_description`, `ord_status_cancelled`, `ord_status_save_default`, `ord_status_resave_default`) VALUES
(1, 'Awaiting Payment', 0, 1, 0),
(2, 'New Order', 0, 0, 1),
(3, 'Processing Order', 0, 0, 0),
(4, 'Order Complete', 0, 0, 0),
(5, 'Order Cancelled', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

CREATE TABLE `order_summary` (
  `ord_order_number` varchar(25) NOT NULL DEFAULT '',
  `ord_cart_data_fk` int(11) NOT NULL DEFAULT '0',
  `ord_user_fk` int(5) NOT NULL DEFAULT '0',
  `ord_item_summary_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_item_summary_savings_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_shipping` varchar(100) NOT NULL DEFAULT '',
  `ord_shipping_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_item_shipping_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_summary_discount_desc` varchar(255) NOT NULL DEFAULT '',
  `ord_summary_savings_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_savings_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_surcharge_desc` varchar(255) NOT NULL DEFAULT '',
  `ord_surcharge_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_reward_voucher_desc` varchar(255) NOT NULL DEFAULT '',
  `ord_reward_voucher_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_tax_rate` varchar(25) NOT NULL DEFAULT '',
  `ord_tax_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_sub_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_total` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_total_rows` int(10) NOT NULL DEFAULT '0',
  `ord_total_items` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_total_weight` double(10,2) NOT NULL DEFAULT '0.00',
  `ord_total_reward_points` int(10) NOT NULL DEFAULT '0',
  `ord_currency` varchar(25) NOT NULL DEFAULT '',
  `ord_exchange_rate` double(8,4) NOT NULL DEFAULT '0.0000',
  `ord_status` tinyint(1) NOT NULL DEFAULT '0',
  `ord_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ord_demo_bill_name` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_bill_company` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_bill_address_01` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_bill_address_02` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_bill_city` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_bill_state` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_bill_post_code` varchar(25) NOT NULL DEFAULT '',
  `ord_demo_bill_country` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_ship_name` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_ship_company` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_ship_address_01` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_ship_address_02` varchar(75) NOT NULL DEFAULT '',
  `ord_demo_ship_city` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_ship_state` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_ship_post_code` varchar(25) NOT NULL DEFAULT '',
  `ord_demo_ship_country` varchar(50) NOT NULL DEFAULT '',
  `ord_demo_email` varchar(255) NOT NULL DEFAULT '',
  `ord_demo_phone` varchar(25) NOT NULL DEFAULT '',
  `ord_demo_comments` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`ord_order_number`, `ord_cart_data_fk`, `ord_user_fk`, `ord_item_summary_total`, `ord_item_summary_savings_total`, `ord_shipping`, `ord_shipping_total`, `ord_item_shipping_total`, `ord_summary_discount_desc`, `ord_summary_savings_total`, `ord_savings_total`, `ord_surcharge_desc`, `ord_surcharge_total`, `ord_reward_voucher_desc`, `ord_reward_voucher_total`, `ord_tax_rate`, `ord_tax_total`, `ord_sub_total`, `ord_total`, `ord_total_rows`, `ord_total_items`, `ord_total_weight`, `ord_total_reward_points`, `ord_currency`, `ord_exchange_rate`, `ord_status`, `ord_date`, `ord_demo_bill_name`, `ord_demo_bill_company`, `ord_demo_bill_address_01`, `ord_demo_bill_address_02`, `ord_demo_bill_city`, `ord_demo_bill_state`, `ord_demo_bill_post_code`, `ord_demo_bill_country`, `ord_demo_ship_name`, `ord_demo_ship_company`, `ord_demo_ship_address_01`, `ord_demo_ship_address_02`, `ord_demo_ship_city`, `ord_demo_ship_state`, `ord_demo_ship_post_code`, `ord_demo_ship_country`, `ord_demo_email`, `ord_demo_phone`, `ord_demo_comments`) VALUES
('00000001', 1, 1, 20.00, 0.00, 'UK Standard Shipping', 3.95, 23.95, '', 0.00, 0.00, '', 0.00, '', 0.00, '20', 3.99, 19.96, 23.95, 1, 1.00, 0.00, 200, 'GBP', 1.0000, 4, '2018-06-13 14:00:04', 'Customer #1', '', '404 Oak Tree Road', '', 'Oaktown', 'Norfolk', 'NR1', 'United Kingdom (EU)', 'Customer #1', '', '404 Oak Tree Road', '', 'Oaktown', 'Norfolk', 'NR1', 'United Kingdom (EU)', 'customer1@fake-email-address.com', '0123456789', 'Example customer order comments'),
('00000002', 2, 2, 74.95, 0.00, 'UK Recorded Shipping', 5.10, 80.05, '', 0.00, 0.00, '', 0.00, '', 0.00, '20', 13.34, 66.71, 80.05, 2, 3.00, 0.00, 750, 'GBP', 1.0000, 4, '2018-06-15 21:33:24', 'Customer #2', '', '301 Kookaburra Close', '', 'Ornington', 'Merseyside', 'L3', 'United Kingdom (EU)', 'Customer #2', '', '55a Lemington Street', '', 'Ornington', 'Merseyside', 'L3', 'United Kingdom (EU)', 'customer2@fake-email-address.com', '0123456789', ''),
('00000003', 3, 3, 116.77, 0.00, 'Australia NSW Shipping', 13.66, 130.43, 'Discount Code "10-PERCENT" - 10% off grand total.', 13.04, 13.04, '', 0.00, '', 0.00, '10', 10.67, 106.72, 117.39, 4, 5.00, 0.00, 1169, 'GBP', 1.0000, 4, '2018-06-18 05:06:44', 'Customer #3', '', '42 Wallaby Way', '', 'Sydney', 'NSW', '2000', 'Australia', 'Customer #3', '', '42 Wallaby Way', '', 'Sydney', 'NSW', '2000', 'Australia', 'customer3@fake-email-address.com', '0123456789', ''),
('00000004', 4, 4, 40.64, 9.03, 'New York State Shipping', 11.96, 52.60, '', 0.00, 9.03, '', 0.00, '', 0.00, '8.37', 4.06, 48.54, 52.60, 2, 4.00, 75.00, 496, 'GBP', 1.0000, 4, '2018-06-20 12:40:04', 'Customer #4', '', '110 E 59th St ', '', 'New York City', 'New York', '10101', 'United States', 'Customer #4', '', '199 E 59th St ', '', 'New York City', 'New York', '10101', 'United States', 'customer4@fake-email-address.com', '0123465789', 'Example customer order comments'),
('00000005', 5, 5, 139.44, 0.00, 'EU Zone 1: Standard Shipping', 7.25, 146.69, 'Discount Code "10-FIXED-RATE" - &pound;10 off grand total.', 10.00, 10.00, '', 0.00, '', 0.00, '20', 22.78, 113.91, 136.69, 3, 3.00, 153.00, 1395, 'GBP', 1.0000, 3, '2018-06-22 20:13:24', 'Customer #5', 'flexi cart', 'Unit 5', '226 Rue Saint-Martin', 'Paris', 'Paris', '75003', 'France (EU)', 'Customer #5', 'flexi cart', 'Unit 5', '226 Rue Saint-Martin', 'Paris', 'Paris', '75003', 'France (EU)', 'customer5@fakeemailaddress.com', '0123456789', ''),
('00000006', 6, 1, 198.50, 6.00, 'UK Collection', 0.00, 198.50, '', 0.00, 6.00, '', 0.00, '', 0.00, '20', 14.83, 183.67, 198.50, 3, 9.00, 75.00, 2045, 'GBP', 1.0000, 4, '2018-06-25 03:46:44', 'Customer #1', '', '404 Oak Tree Road', '', 'Oaktown', 'Norfolk', 'NR1', 'United Kingdom (EU)', 'Customer #1', '', '404 Oak Tree Road', '', 'Oaktown', 'Norfolk', 'NR1', 'United Kingdom (EU)', 'customer1@fake-email-address.com', '0123456798', ''),
('00000007', 7, 3, 36.62, 0.00, 'Australia NSW Shipping', 27.31, 63.93, '', 0.00, 0.00, '', 0.00, '', 0.00, '10', 5.81, 58.12, 63.93, 2, 2.00, 0.00, 366, 'GBP', 1.0000, 5, '2018-06-27 11:20:04', 'Customer #3', '', '42 Wallaby Way', '', 'Sydney', 'NSW', '2000', 'Australia', 'Customer #3', '', '42 Wallaby Way', '', 'Sydney', 'NSW', '2000', 'Australia', 'customer3@fake-email-address.com', '0123465789', ''),
('00000008', 8, 4, 244.19, 0.00, 'United States (Non CA or NY) Shipping', 12.80, 256.99, '', 0.00, 0.00, '', 0.00, '', 0.00, '6', 14.55, 0.00, 256.99, 3, 4.00, 250.00, 2442, 'GBP', 1.0000, 2, '2018-06-29 18:53:24', 'Customer #4', '', '110 E 59th St', '', 'New York City', 'New York', '10101', 'United States', 'Customer #4', '', '110 E 59th St', '', 'New York City', 'New York', '10101', 'United States', 'customer4@fake-email-address.com', '0123456789', ''),
('409816815N902352C', 11, 0, 4.00, 0.00, 'UK Standard Shipping', 5.26, 9.26, '', 0.00, 0.00, '', 0.00, '', 0.00, '20', 1.54, 0.00, 9.26, 1, 1.00, 490.00, 40, 'GBP', 1.0000, 2, '2018-06-30 22:36:09', '', '', '', '', '', '', '', '', 'test buyer', '', '1 Main St', '', 'San Jose', 'CA', '95131', 'US', '', '408-226-2903', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `body` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `body`) VALUES
(1, 'About us', 'About-us', '<h3>Vivamuslibero Auguer</h3>\r\n<p>\r\n    Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam, quis nostrud exercitation \r\n    ullamco.\r\n</p>\r\n<p>\r\n    Laboris nisi ut aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.\r\n</p>');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tags` varchar(200) NOT NULL DEFAULT '',
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `weight` double(8,2) NOT NULL DEFAULT '0.00',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `tags`, `price`, `weight`, `thumb`, `quantity`, `status`) VALUES
(2, 'Bowknot Embellished Butterfly Print Tea Length Vintage Dress', 'Bowknot-Embellished-Butterfly-Print-Tea-Length-Vintage-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 5.00, 500.00, 'assets/images/dbe82763f0d7b6cc352c4c54b5348a02.jpg', 100, 1),
(3, 'Buttoned Polka Dot Vintage Corset Dress', 'Buttoned-Polka-Dot-Vintage-Corset-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.50, 590.00, 'assets/images/4c36e04189016353f0e48829609cda0a.jpg', 100, 1),
(4, 'Double Breasted Striped Mermaid Dress', 'Double-Breasted-Striped-Mermaid-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 5.00, 520.00, 'assets/images/2ec731b1410a88410ba41e994e5c760f.jpg', 100, 1),
(5, 'Floral Flamingo Print Striped Vintage Dress', 'Floral-Flamingo-Print-Striped-Vintage-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.00, 510.00, 'assets/images/de49552f9a01535a9e2d9861a2598ec5.jpg', 100, 1),
(6, 'Floral Tea Length Vintage Swing Dress', 'Floral-Tea-Length-Vintage-Swing-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.00, 490.00, 'assets/images/f9028d67ba18c83b5114e70265f1b6a7.jpg', 64, 1),
(7, 'Halter American Flag Buttoned Vintage Dress', 'Halter-American-Flag-Buttoned-Vintage-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.00, 500.00, 'assets/images/1512cef226bad44d6e9bbbc08d5ee2b5.jpg', 32, 1),
(8, 'Low Cut Vintage Wrap Dress', 'Low-Cut-Vintage-Wrap-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 6.50, 610.00, 'assets/images/f79b9c03caddfb77139715b38490633b.jpg', 0, 1),
(9, 'Retro Style Women\'s V-Neck Rose Print Short Sleeve Ball Dress', 'Retro-Style-Womens-V-Neck-Rose-Print-Short-Sleeve-Ball-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 2.50, 520.00, 'assets/images/5eae4619350720954c6ac48e0e3fdb27.JPG', 0, 1),
(10, 'Single Breasted Floral 50s Swing Dress', 'Single-Breasted-Floral-50s-Swing-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.50, 510.00, 'assets/images/5f47cda097e97b534f320436576f05d0.jpg', 0, 1),
(11, 'Striped Off The Shoulder Vintage Dress', 'Striped-Off-The-Shoulder-Vintage-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 5.00, 550.00, 'assets/images/1c8b988de2748f0c80b95aa59a4432bb.jpg', 50, 1),
(12, 'Two Tone Halter Vintage Dress', 'Two-Tone-Halter-Vintage-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.20, 510.00, 'assets/images/fa21679bb111a1d3bf17db83efddc6ff.jpg', 28, 1),
(13, 'Vintage Bowknot V Neck Pin Up Dress', 'Vintage-Bowknot-V-Neck-Pin-Up-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 5.00, 510.00, 'assets/images/2cff046bbcfdbf49fbdb8dda497515c4.jpg', 10, 1),
(14, 'Vintage Embroidered Flare Dress', 'Vintage-Embroidered-Flare-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.20, 500.00, 'assets/images/93260c150b9ce65b65314cd0cac2234b.jpg', 45, 1),
(15, 'Vintage Fit and Flare Dress', 'Vintage-Fit-and-Flare-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.00, 500.00, 'assets/images/a658a1781d0e7472dbcdc086bc5cc9c7.jpg', 20, 1),
(16, 'Vintage Floral Jacquard Fit and Flare Dress', 'Vintage-Floral-Jacquard-Fit-and-Flare-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.80, 510.00, 'assets/images/eecd58084ae11d320d9cdc7df3d75b03.jpg', 10, 1),
(17, 'Vintage Floral Print A Line High Waisted Dress', 'Vintage-Floral-Print-A-Line-High-Waisted-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.20, 580.00, 'assets/images/1d4573b4aca38c7390e0e1276a514805.jpg', 30, 1),
(18, 'Vintage Floral Print Midi Dress', 'Vintage-Floral-Print-Midi-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 3.60, 520.00, 'assets/images/2f5a3e8b55e0938082752313fe5c96d4.jpg', 25, 1),
(19, 'Vintage Halter Floral Print Dress', 'Vintage-Halter-Floral-Print-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 4.30, 500.00, 'assets/images/bb843c352bfaaeb0a6acf036201c99fa.jpg', 15, 1),
(20, 'Vintage Spaghetti Strap Solid Color Asymmetrical Dress Gothic', 'Vintage-Spaghetti-Strap-Solid-Color-Asymmetrical-Dress-Gothic', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 20.00, 500.00, 'assets/images/ec3275167a144f6a1395bac40cd9cc22.jpg', 10, 1),
(21, 'Vintage Style Scoop Neck 34 Sleeve HIt Color Dress For Women', 'Vintage-Style-Scoop-Neck-34-Sleeve-HIt-Color-Dress-For-Women', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 5.00, 530.00, 'assets/images/b1a8435f72fe7d3567188fadd3eb15c5.jpg', 42, 1),
(22, 'Vintage Sweetheart Neck Overlay Dress', 'Vintage-Sweetheart-Neck-Overlay-Dress', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nihil ad suscipit deserunt eos ex harum quod quae repellat magni odit laudantium possimus praesentium quam, aperiam cumque, repudiandae inventore eius.', '', 6.00, 500.00, 'assets/images/8437596b3497f891f1ed6eed450e3fcc.jpg', 5, 1),
(23, 'Stiletto Heel Rhinestones Slingback Sandals', 'Stiletto-Heel-Rhinestones-Slingback-Sandals', 'Stiletto Heel Rhinestones Slingback Sandals', 'red', 21.76, 800.00, 'assets/images/beb2d21a3334cbddeafb38b142a72ee7.jpg', 0, 1),
(24, 'Faux Leather Flower Sandals - Blackish Green', 'Faux-Leather-Flower-Sandals-Blackish-Green', 'Faux Leather Flower Sandals - Blackish Green', '', 11.07, 400.00, 'assets/images/4efea9abc6203b0722e2b14636b483ad.jpg', 85, 1),
(25, 'Stiletto Heel Cross Straps Sandals', 'Stiletto-Heel-Cross-Straps-Sandals', 'Stiletto Heel Cross Straps Sandals', '', 19.82, 420.00, 'assets/images/a51b0f667fa7aed95fbf99b382e4373d.jpg', 0, 1),
(26, 'Chunky Heel Two Tone Sandals - White And Black', 'Chunky-Heel-Two-Tone-Sandals-White-And-Black', 'Chunky Heel Two Tone Sandals - White And Black', '', 18.86, 400.00, 'assets/images/81ce7d4ed55754dfa28332847736196a.jpg', 43, 1),
(27, 'Wedge Heel Faux Leather Sandals', 'Wedge-Heel-Faux-Leather-Sandals', 'Wedge Heel Faux Leather Sandals', '', 16.58, 520.00, 'assets/images/cbcde577538c9c045a86dc52f63d340d.jpg', 21, 1),
(28, 'Chains Lace Up Sandals', 'Chains-Lace-Up-Sandals', 'Chains Lace Up Sandals', '', 23.18, 500.00, 'assets/images/d03a8fca853d8700d12fce8229cac161.png', 23, 1),
(29, 'Weesky Leather Band Date Display Quartz Watch Golden Case', 'Weesky-Leather-Band-Date-Display-Quartz-Watch-Golden-Case', 'Weesky Leather Band Date Display Quartz Watch Golden Case', '', 3.59, 500.00, 'assets/images/9132ef14d76084b41e234a8de8d58224.jpg', 45, 1),
(30, 'Circle Dial Plate Adorn Quartz Watch', 'Circle-Dial-Plate-Adorn-Quartz-Watch', 'Circle Dial Plate Adorn Quartz Watch', '', 4.29, 200.00, 'assets/images/29d1a6e6b56143d2636607d1e3b10d4a.jpg', 53, 1),
(31, 'contena GENEVA Business Style Diamond Round Dial Female Quartz Watch', 'contena-GENEVA-Business-Style-Diamond-Round-Dial-Female-Quartz-Watch', 'contena GENEVA Business Style Diamond Round Dial Female Quartz Watch', '', 4.93, 500.00, 'assets/images/4d8d1c6259631b86527274da4f3c5dbe.jpg', 76, 1),
(32, 'Rhinestone PU Leather Bracelet Watch', 'Rhinestone-PU-Leather-Bracelet-Watch', 'Rhinestone PU Leather Bracelet Watch', '', 4.32, 420.00, 'assets/images/7e3cea561b9d19aec2228df5b45a5cb4.jpg', 0, 1),
(33, 'Dandy 221 Ladies Quartz Watch Diamond Case Bracelet with Steel Wire Strap', 'Dandy-221-Ladies-Quartz-Watch-Diamond-Case-Bracelet-with-Steel-Wire-Strap', 'Dandy 221 Ladies Quartz Watch Diamond Case Bracelet with Steel Wire Strap', '', 2.97, 50.00, 'assets/images/e136a2f2503a2f24c3f30ba9611e29d6.jpg', 24, 1),
(34, 'Vintage Wooden Pattern Watch', 'Vintage-Wooden-Pattern-Watch', 'Vintage Wooden Pattern Watch', '', 3.62, 420.00, 'assets/images/c802a2528b16d03fe3c5f05ac517908a.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` smallint(5) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` smallint(5) NOT NULL,
  `attribute_description_id` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_id`, `attribute_description_id`) VALUES
(4, 3, 1, 1),
(5, 3, 2, 6),
(6, 3, 2, 7),
(7, 3, 3, 10),
(8, 6, 1, 5),
(9, 6, 2, 6),
(10, 6, 2, 7),
(11, 6, 3, 10),
(12, 5, 1, 4),
(13, 5, 2, 6),
(14, 5, 2, 7),
(15, 5, 3, 10),
(16, 4, 1, 5),
(17, 4, 2, 6),
(18, 4, 2, 7),
(19, 4, 3, 10),
(20, 7, 1, 1),
(21, 7, 2, 7),
(22, 7, 3, 9),
(23, 7, 3, 10),
(24, 8, 1, 3),
(25, 8, 2, 6),
(26, 8, 2, 7),
(27, 8, 3, 10),
(28, 8, 3, 11),
(29, 9, 1, 1),
(30, 9, 2, 6),
(31, 9, 3, 9),
(32, 10, 1, 4),
(33, 10, 2, 7),
(34, 10, 3, 9),
(35, 10, 3, 10),
(36, 12, 1, 1),
(37, 12, 2, 6),
(38, 12, 2, 7),
(39, 12, 3, 9),
(40, 12, 3, 10),
(41, 14, 1, 1),
(42, 14, 2, 6),
(43, 14, 2, 7),
(44, 14, 3, 9),
(45, 14, 3, 10),
(46, 15, 1, 4),
(47, 15, 2, 6),
(48, 15, 2, 7),
(49, 15, 3, 9),
(50, 15, 3, 10),
(51, 16, 1, 1),
(52, 16, 1, 2),
(53, 16, 2, 6),
(54, 16, 2, 7),
(55, 16, 3, 9),
(56, 16, 3, 10),
(57, 17, 1, 1),
(58, 17, 1, 2),
(59, 17, 2, 6),
(60, 17, 2, 7),
(61, 17, 3, 9),
(62, 17, 3, 10),
(63, 18, 1, 1),
(64, 18, 1, 2),
(65, 18, 2, 6),
(66, 18, 2, 7),
(67, 18, 3, 9),
(68, 18, 3, 10),
(74, 19, 1, 5),
(75, 19, 2, 6),
(76, 19, 2, 7),
(77, 19, 3, 9),
(78, 19, 3, 10),
(79, 20, 1, 1),
(80, 20, 2, 6),
(81, 20, 2, 7),
(82, 20, 3, 9),
(83, 21, 1, 1),
(84, 21, 2, 6),
(85, 21, 3, 10),
(86, 21, 3, 11),
(87, 26, 4, 14),
(88, 24, 4, 15),
(89, 25, 4, 12),
(90, 27, 4, 13),
(91, 28, 4, 12),
(95, 33, 5, 17),
(97, 29, 5, 17),
(98, 29, 6, 19),
(99, 30, 5, 17),
(100, 30, 6, 18),
(101, 31, 5, 17),
(102, 31, 6, 18),
(103, 32, 5, 17),
(104, 32, 6, 18),
(105, 34, 5, 17),
(106, 34, 6, 19),
(108, 38, 7, 20),
(109, 38, 7, 21),
(116, 2, 7, 20),
(117, 2, 7, 21),
(118, 2, 8, 22),
(119, 2, 8, 23);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` smallint(5) NOT NULL,
  `parent_id` smallint(5) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `sort_order` smallint(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(3, 5, 'vintage', 'VNT-0000', 0, 1),
(4, 5, 'bodycon', 'BDC-0000', 0, 1),
(5, NULL, 'dresses', 'DRS-0005', 0, 1),
(6, NULL, 'shoes', 'SHS-0006', 0, 1),
(7, NULL, 'Watches', 'WTC-0007', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` smallint(5) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 3),
(4, 4, 4),
(5, 5, 3),
(6, 6, 3),
(7, 7, 3),
(8, 8, 5),
(9, 9, 5),
(10, 10, 5),
(11, 11, 3),
(12, 12, 3),
(13, 13, 3),
(14, 14, 3),
(15, 15, 3),
(16, 16, 3),
(17, 17, 3),
(18, 18, 3),
(19, 19, 3),
(20, 20, 3),
(21, 21, 3),
(22, 22, 3),
(23, 23, 6),
(24, 24, 6),
(25, 25, 6),
(26, 26, 6),
(27, 27, 6),
(28, 28, 6),
(29, 29, 7),
(30, 30, 7),
(31, 31, 7),
(32, 32, 7),
(33, 33, 7),
(34, 34, 7),
(35, 35, 5),
(36, 36, 5),
(37, 37, 5),
(38, 38, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_attributes`
--

CREATE TABLE `product_category_attributes` (
  `id` smallint(5) NOT NULL,
  `category_id` smallint(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_option` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category_attributes`
--

INSERT INTO `product_category_attributes` (`id`, `category_id`, `name`, `is_option`) VALUES
(1, 2, 'color', 1),
(2, 2, 'size', 1),
(3, 2, 'length', 0),
(4, 6, 'Heel type', 0),
(5, 7, 'Dail Display', 0),
(6, 7, 'Band Material', 0),
(7, 3, 'color', 1),
(8, 5, 'size', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_attribute_descriptions`
--

CREATE TABLE `product_category_attribute_descriptions` (
  `id` smallint(5) NOT NULL,
  `attribute_id` smallint(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category_attribute_descriptions`
--

INSERT INTO `product_category_attribute_descriptions` (`id`, `attribute_id`, `name`) VALUES
(1, 1, 'black'),
(2, 1, 'white'),
(3, 1, 'teal'),
(4, 1, 'red'),
(5, 1, 'multi'),
(6, 2, 'small'),
(7, 2, 'medium'),
(8, 2, 'large'),
(9, 3, 'short'),
(10, 3, 'medium'),
(11, 3, 'long'),
(12, 4, 'Stiletto'),
(13, 4, 'Wedge'),
(14, 4, 'Chunky'),
(15, 4, 'Flat'),
(16, 5, 'Digital'),
(17, 5, 'Pointer'),
(18, 6, 'Steel'),
(19, 6, 'Leather'),
(20, 7, 'black'),
(21, 7, 'red'),
(22, 8, 'Small'),
(23, 8, 'Medium'),
(24, 8, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `sort_order`) VALUES
(2, 38, 'assets/images/536644d4beffa617452ed02ab9da6181.jpg', 0),
(3, 2, 'assets/images/b4c717fa2a031fc4fc9201c645939ed0.jpg', 0),
(4, 3, 'assets/images/35e931e225758c83bf43b01b2f7787b6.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `weight` double(8,2) NOT NULL DEFAULT '0.00',
  `stock` int(5) NOT NULL,
  `stock_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `price`, `weight`, `stock`, `stock_status`) VALUES
(2, 38, 2.50, 0.00, 0, 1),
(4, 2, 6.00, 0.00, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_option_defaults`
--

CREATE TABLE `product_option_defaults` (
  `id` smallint(5) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_description_id` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_groups`
--

CREATE TABLE `product_option_groups` (
  `id` smallint(5) NOT NULL,
  `product_option_id` smallint(5) NOT NULL,
  `attribute_description_id` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_option_groups`
--

INSERT INTO `product_option_groups` (`id`, `product_option_id`, `attribute_description_id`) VALUES
(1, 1, 21),
(3, 2, 21),
(5, 2, 21),
(6, 2, 21),
(7, 2, 21),
(8, 2, 21),
(9, 3, 21),
(10, 4, 21),
(11, 4, 21);

-- --------------------------------------------------------

--
-- Table structure for table `product_option_images`
--

CREATE TABLE `product_option_images` (
  `id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_option_images`
--

INSERT INTO `product_option_images` (`id`, `product_option_id`, `url`, `sort_order`) VALUES
(6, 2, 'assets/images/031845fc4d0e7a3175b776c97febb22f.jpg', 0),
(8, 4, 'assets/images/bfad379679c9d73a3128c01d28900877.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reward_points_converted`
--

CREATE TABLE `reward_points_converted` (
  `rew_convert_id` int(10) NOT NULL,
  `rew_convert_ord_detail_fk` int(10) NOT NULL DEFAULT '10',
  `rew_convert_discount_fk` varchar(50) NOT NULL DEFAULT '',
  `rew_convert_points` int(10) NOT NULL DEFAULT '10',
  `rew_convert_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reward_points_converted`
--

INSERT INTO `reward_points_converted` (`rew_convert_id`, `rew_convert_ord_detail_fk`, `rew_convert_discount_fk`, `rew_convert_points`, `rew_convert_date`) VALUES
(1, 1, '35', 400, '2017-06-26 07:33:24'),
(2, 2, '35', 100, '2017-06-27 11:20:04'),
(3, 7, '36', 1000, '2017-06-28 15:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_item_rules`
--

CREATE TABLE `shipping_item_rules` (
  `ship_item_id` int(11) NOT NULL,
  `ship_item_item_fk` int(11) NOT NULL DEFAULT '0',
  `ship_item_location_fk` smallint(5) NOT NULL DEFAULT '0',
  `ship_item_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `ship_item_value` double(8,4) DEFAULT NULL,
  `ship_item_separate` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indicate if item should have a shipping rate calculated specifically for it.',
  `ship_item_banned` tinyint(1) NOT NULL DEFAULT '0',
  `ship_item_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_item_rules`
--

INSERT INTO `shipping_item_rules` (`ship_item_id`, `ship_item_item_fk`, `ship_item_location_fk`, `ship_item_zone_fk`, `ship_item_value`, `ship_item_separate`, `ship_item_banned`, `ship_item_status`) VALUES
(1, 104, 1, 0, 0.0000, 0, 0, 1),
(2, 106, 0, 0, NULL, 1, 0, 1),
(3, 107, 1, 0, NULL, 0, 1, 1),
(4, 108, 1, 0, NULL, 0, 2, 1),
(5, 108, 2, 0, NULL, 0, 2, 1),
(6, 2, 10, 0, 5.0000, 0, 0, 1),
(7, 2, 0, 1, 3.0000, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_options`
--

CREATE TABLE `shipping_options` (
  `ship_id` smallint(5) NOT NULL,
  `ship_name` varchar(50) NOT NULL DEFAULT '',
  `ship_description` varchar(50) NOT NULL DEFAULT '',
  `ship_location_fk` smallint(5) NOT NULL DEFAULT '0',
  `ship_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `ship_inc_sub_locations` tinyint(1) NOT NULL DEFAULT '0',
  `ship_tax_rate` double(7,4) DEFAULT NULL,
  `ship_discount_inclusion` tinyint(1) NOT NULL DEFAULT '0',
  `ship_status` tinyint(1) NOT NULL DEFAULT '0',
  `ship_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_options`
--

INSERT INTO `shipping_options` (`ship_id`, `ship_name`, `ship_description`, `ship_location_fk`, `ship_zone_fk`, `ship_inc_sub_locations`, `ship_tax_rate`, `ship_discount_inclusion`, `ship_status`, `ship_default`) VALUES
(1, 'UK Standard Shipping', '2-3 Days', 1, 0, 0, NULL, 1, 1, 1),
(2, 'UK Recorded Shipping', '2-3 Days', 1, 0, 0, NULL, 0, 1, 0),
(3, 'UK Special Shipping', 'Next Day', 1, 0, 0, NULL, 0, 1, 0),
(4, 'UK Collection', 'Available Next Day', 1, 0, 0, NULL, 0, 1, 0),
(5, 'EU Zone 1: Standard Shipping', '3-4 Days', 0, 1, 0, NULL, 0, 1, 0),
(6, 'EU Zone 1: Special Shipping', '1-2 Days', 0, 1, 0, NULL, 0, 1, 0),
(7, 'EU Zone 2: Standard Shipping', '4-6 Days', 0, 2, 0, NULL, 0, 1, 0),
(8, 'EU Zone 2: Special Shipping', '2-4 Days', 0, 2, 0, NULL, 0, 1, 0),
(9, 'EU Zone 3: Standard Shipping', '5-8 Days', 0, 3, 0, NULL, 0, 1, 0),
(10, 'EU Zone 3: Special Shipping', '3-5 Days', 0, 3, 0, NULL, 0, 1, 0),
(11, 'Australia (Non NSW) Shipping', '12 Days', 8, 0, 0, NULL, 0, 1, 0),
(12, 'Australia NSW Shipping', '10 Days', 11, 0, 0, NULL, 0, 1, 0),
(13, 'Canada Shipping', '8 Days', 9, 0, 0, NULL, 0, 1, 0),
(14, 'United States (Non CA or NY) Shipping', '8 Days', 10, 0, 0, NULL, 0, 1, 0),
(15, 'New York State Shipping', '6 Days', 16, 0, 1, NULL, 0, 1, 0),
(16, 'California State Shipping', '8 Days', 14, 0, 0, NULL, 0, 1, 0),
(17, 'New York City Shipping', '6 Days', 18, 0, 0, NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `ship_rate_id` smallint(5) NOT NULL,
  `ship_rate_ship_fk` smallint(5) NOT NULL DEFAULT '0',
  `ship_rate_value` double(8,2) NOT NULL DEFAULT '0.00',
  `ship_rate_tare_wgt` double(8,2) NOT NULL DEFAULT '0.00',
  `ship_rate_min_wgt` double(8,2) NOT NULL DEFAULT '0.00',
  `ship_rate_max_wgt` double(8,2) NOT NULL DEFAULT '9999.00',
  `ship_rate_min_value` double(10,2) NOT NULL DEFAULT '0.00',
  `ship_rate_max_value` double(10,2) NOT NULL DEFAULT '9999.00',
  `ship_rate_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_rates`
--

INSERT INTO `shipping_rates` (`ship_rate_id`, `ship_rate_ship_fk`, `ship_rate_value`, `ship_rate_tare_wgt`, `ship_rate_min_wgt`, `ship_rate_max_wgt`, `ship_rate_min_value`, `ship_rate_max_value`, `ship_rate_status`) VALUES
(1, 1, 3.95, 2.00, 0.00, 50.00, 0.00, 500.00, 1),
(2, 1, 4.50, 2.00, 50.00, 150.00, 0.00, 500.00, 1),
(3, 1, 5.25, 2.00, 150.00, 500.00, 0.00, 500.00, 1),
(4, 2, 5.10, 2.00, 0.00, 50.00, 0.00, 500.00, 1),
(5, 2, 5.75, 2.00, 50.00, 150.00, 0.00, 500.00, 1),
(6, 2, 6.40, 2.00, 150.00, 500.00, 0.00, 500.00, 1),
(7, 3, 7.50, 10.00, 0.00, 500.00, 0.00, 1000.00, 1),
(8, 3, 10.95, 10.00, 500.00, 0.00, 0.00, 9999.00, 1),
(9, 4, 0.00, 10.00, 0.00, 0.00, 0.00, 9999.00, 1),
(10, 5, 7.25, 10.00, 0.00, 250.00, 0.00, 500.00, 1),
(11, 6, 15.75, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(12, 7, 7.75, 10.00, 0.00, 250.00, 0.00, 500.00, 1),
(13, 8, 16.25, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(14, 9, 8.50, 10.00, 0.00, 250.00, 0.00, 500.00, 1),
(15, 10, 20.10, 0.00, 0.00, 0.00, 0.00, 0.00, 1),
(16, 11, 16.50, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(17, 12, 14.90, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(18, 13, 14.50, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(19, 14, 14.50, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(20, 15, 13.25, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(21, 16, 15.30, 10.00, 0.00, 0.00, 0.00, 0.00, 1),
(22, 17, 10.55, 10.00, 0.00, 0.00, 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` smallint(5) NOT NULL,
  `tax_location_fk` smallint(5) NOT NULL DEFAULT '0',
  `tax_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `tax_name` varchar(25) NOT NULL DEFAULT '',
  `tax_rate` double(7,4) NOT NULL DEFAULT '0.0000',
  `tax_status` tinyint(1) NOT NULL DEFAULT '0',
  `tax_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_location_fk`, `tax_zone_fk`, `tax_name`, `tax_rate`, `tax_status`, `tax_default`) VALUES
(1, 0, 4, 'VAT', 20.0000, 1, 1),
(2, 0, 5, 'No Tax (Non EU)', 0.0000, 1, 0),
(3, 16, 0, 'Tax New York', 4.0000, 1, 0),
(4, 14, 0, 'Tax California', 8.2500, 1, 0),
(5, 10, 0, 'Tax (Other US)', 6.0000, 1, 0),
(6, 18, 0, 'Tax New York City', 8.3700, 1, 0),
(7, 8, 0, 'GST', 10.0000, 1, 0),
(8, 9, 0, 'HST', 8.0000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tax_item_rates`
--

CREATE TABLE `tax_item_rates` (
  `tax_item_id` int(11) NOT NULL,
  `tax_item_item_fk` int(11) NOT NULL DEFAULT '0',
  `tax_item_location_fk` smallint(5) NOT NULL DEFAULT '0',
  `tax_item_zone_fk` smallint(5) NOT NULL DEFAULT '0',
  `tax_item_rate` double(7,4) NOT NULL DEFAULT '0.0000',
  `tax_item_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax_item_rates`
--

INSERT INTO `tax_item_rates` (`tax_item_id`, `tax_item_item_fk`, `tax_item_location_fk`, `tax_item_zone_fk`, `tax_item_rate`, `tax_item_status`) VALUES
(1, 110, 0, 0, 0.0000, 1),
(2, 2, 10, 0, 3.0000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  `avatar` varchar(220) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `postal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `avatar`, `first_name`, `last_name`, `address`, `phone`, `postal`) VALUES
(1, '127.0.0.1', 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1519500928, 1, 'assets/images/logo.jpg', 'My Store', 'istrator', 'Admin Homestead', '000000000', ''),
(2, '::1', 'usernash', '$2y$08$zD4NvCfZmAvdpm0JCDNjt.7UG7Y5IOA7JfWK3K6g3DIKx9PqDMoMa', '', 'ignatiusyesigye@gmail.com', NULL, NULL, NULL, NULL, 1497383454, 1497554503, 1, 'assets/images/063772b51874a6afce3b7c97a96f05e8.jpg', 'ignatius', 'yesigye', 'kampala, uganda', '+256758442440', ''),
(3, '::1', 'naturelover', '$2y$08$vReh9ZOw0457xjGHWqGtF.Ok4qpAPRQsjLcqUN58aaWEOZg.V5Uui', '', 'naturelover@email.com', NULL, NULL, NULL, NULL, 1519500806, NULL, 1, 'assets/images/b382fd718b810b8d2dff5a50ddf53f66.jpg', 'naturo', 'stormchaser', 'planet earth', '+123456789', ''),
(4, '::1', 'beachman', '$2y$08$4dVtYDKKTjM.pqNo/Nv09.br6mAfcjhozW0cFJcJ/q9GdRNyK.xwC', '', 'beachman@email.com', NULL, NULL, NULL, NULL, 1519500913, NULL, 1, 'assets/images/c7b884b0521d4596b0ac14cae216e2fa.jpg', 'moses', 'beachingly', 'sea shores', '+123456789', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `cart_config`
--
ALTER TABLE `cart_config`
  ADD PRIMARY KEY (`config_id`),
  ADD UNIQUE KEY `config_id` (`config_id`);

--
-- Indexes for table `cart_data`
--
ALTER TABLE `cart_data`
  ADD PRIMARY KEY (`cart_data_id`),
  ADD UNIQUE KEY `cart_data_id` (`cart_data_id`) USING BTREE,
  ADD KEY `cart_data_user_fk` (`cart_data_user_fk`) USING BTREE;

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`curr_id`),
  ADD KEY `curr_id` (`curr_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`disc_id`),
  ADD UNIQUE KEY `disc_id` (`disc_id`) USING BTREE,
  ADD KEY `disc_item_fk` (`disc_item_fk`),
  ADD KEY `disc_location_fk` (`disc_location_fk`),
  ADD KEY `disc_zone_fk` (`disc_zone_fk`),
  ADD KEY `disc_method_fk` (`disc_method_fk`) USING BTREE,
  ADD KEY `disc_type_fk` (`disc_type_fk`),
  ADD KEY `disc_group_fk` (`disc_group_fk`) USING BTREE;

--
-- Indexes for table `discount_calculation`
--
ALTER TABLE `discount_calculation`
  ADD PRIMARY KEY (`disc_calculation_id`),
  ADD UNIQUE KEY `disc_calculation_id` (`disc_calculation_id`) USING BTREE;

--
-- Indexes for table `discount_columns`
--
ALTER TABLE `discount_columns`
  ADD PRIMARY KEY (`disc_column_id`),
  ADD UNIQUE KEY `disc_column_id` (`disc_column_id`) USING BTREE;

--
-- Indexes for table `discount_groups`
--
ALTER TABLE `discount_groups`
  ADD PRIMARY KEY (`disc_group_id`),
  ADD UNIQUE KEY `disc_group_id` (`disc_group_id`) USING BTREE;

--
-- Indexes for table `discount_group_items`
--
ALTER TABLE `discount_group_items`
  ADD PRIMARY KEY (`disc_group_item_id`),
  ADD UNIQUE KEY `disc_group_item_id` (`disc_group_item_id`) USING BTREE,
  ADD KEY `disc_group_item_group_fk` (`disc_group_item_group_fk`) USING BTREE,
  ADD KEY `disc_group_item_item_fk` (`disc_group_item_item_fk`) USING BTREE;

--
-- Indexes for table `discount_methods`
--
ALTER TABLE `discount_methods`
  ADD PRIMARY KEY (`disc_method_id`),
  ADD UNIQUE KEY `disc_method_id` (`disc_method_id`),
  ADD KEY `disc_method_type_fk` (`disc_method_type_fk`),
  ADD KEY `disc_method_column_fk` (`disc_method_column_fk`),
  ADD KEY `disc_method_calculation_fk` (`disc_method_calculation_fk`);

--
-- Indexes for table `discount_tax_methods`
--
ALTER TABLE `discount_tax_methods`
  ADD PRIMARY KEY (`disc_tax_method_id`),
  ADD UNIQUE KEY `disc_tax_method_id` (`disc_tax_method_id`) USING BTREE;

--
-- Indexes for table `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`disc_type_id`),
  ADD UNIQUE KEY `disc_type_id` (`disc_type_id`) USING BTREE;

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD UNIQUE KEY `stock_id` (`stock_id`) USING BTREE,
  ADD KEY `stock_item_fk` (`stock_item_fk`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`loc_id`),
  ADD UNIQUE KEY `loc_id` (`loc_id`) USING BTREE,
  ADD KEY `loc_type_fk` (`loc_type_fk`) USING BTREE,
  ADD KEY `loc_tax_zone_fk` (`loc_tax_zone_fk`),
  ADD KEY `loc_ship_zone_fk` (`loc_ship_zone_fk`),
  ADD KEY `loc_parent_fk` (`loc_parent_fk`) USING BTREE;

--
-- Indexes for table `location_type`
--
ALTER TABLE `location_type`
  ADD PRIMARY KEY (`loc_type_id`),
  ADD UNIQUE KEY `loc_type_id` (`loc_type_id`),
  ADD KEY `loc_type_parent_fk` (`loc_type_parent_fk`);

--
-- Indexes for table `location_zones`
--
ALTER TABLE `location_zones`
  ADD PRIMARY KEY (`lzone_id`),
  ADD UNIQUE KEY `lzone_id` (`lzone_id`) USING BTREE;

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`ord_det_id`),
  ADD UNIQUE KEY `ord_det_id` (`ord_det_id`) USING BTREE,
  ADD KEY `ord_det_order_number_fk` (`ord_det_order_number_fk`) USING BTREE,
  ADD KEY `ord_det_item_fk` (`ord_det_item_fk`) USING BTREE;

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`ord_status_id`),
  ADD KEY `ord_status_id` (`ord_status_id`);

--
-- Indexes for table `order_summary`
--
ALTER TABLE `order_summary`
  ADD PRIMARY KEY (`ord_order_number`),
  ADD UNIQUE KEY `ord_order_number` (`ord_order_number`) USING BTREE,
  ADD KEY `ord_cart_data_fk` (`ord_cart_data_fk`) USING BTREE,
  ADD KEY `ord_user_fk` (`ord_user_fk`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_category_attribute_descriptions`
--
ALTER TABLE `product_category_attribute_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_option_defaults`
--
ALTER TABLE `product_option_defaults`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_option_groups`
--
ALTER TABLE `product_option_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product_option_images`
--
ALTER TABLE `product_option_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `reward_points_converted`
--
ALTER TABLE `reward_points_converted`
  ADD PRIMARY KEY (`rew_convert_id`),
  ADD UNIQUE KEY `rew_convert_id` (`rew_convert_id`) USING BTREE,
  ADD KEY `rew_convert_discount_fk` (`rew_convert_discount_fk`),
  ADD KEY `rew_convert_ord_detail_fk` (`rew_convert_ord_detail_fk`) USING BTREE;

--
-- Indexes for table `shipping_item_rules`
--
ALTER TABLE `shipping_item_rules`
  ADD PRIMARY KEY (`ship_item_id`),
  ADD UNIQUE KEY `ship_item_id` (`ship_item_id`) USING BTREE,
  ADD KEY `ship_item_zone_fk` (`ship_item_zone_fk`) USING BTREE,
  ADD KEY `ship_item_location_fk` (`ship_item_location_fk`) USING BTREE,
  ADD KEY `ship_item_item_fk` (`ship_item_item_fk`) USING BTREE;

--
-- Indexes for table `shipping_options`
--
ALTER TABLE `shipping_options`
  ADD PRIMARY KEY (`ship_id`),
  ADD UNIQUE KEY `ship_id` (`ship_id`) USING BTREE,
  ADD KEY `ship_zone_fk` (`ship_zone_fk`) USING BTREE,
  ADD KEY `ship_location_fk` (`ship_location_fk`) USING BTREE;

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`ship_rate_id`),
  ADD UNIQUE KEY `ship_rate_id` (`ship_rate_id`) USING BTREE,
  ADD KEY `ship_rate_ship_fk` (`ship_rate_ship_fk`) USING BTREE;

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`),
  ADD UNIQUE KEY `tax_id` (`tax_id`),
  ADD KEY `tax_zone_fk` (`tax_zone_fk`),
  ADD KEY `tax_location_fk` (`tax_location_fk`) USING BTREE;

--
-- Indexes for table `tax_item_rates`
--
ALTER TABLE `tax_item_rates`
  ADD PRIMARY KEY (`tax_item_id`),
  ADD UNIQUE KEY `tax_item_id` (`tax_item_id`) USING BTREE,
  ADD KEY `tax_item_zone_fk` (`tax_item_zone_fk`),
  ADD KEY `tax_item_location_fk` (`tax_item_location_fk`),
  ADD KEY `tax_item_item_fk` (`tax_item_item_fk`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_users_groups_users` (`user_id`),
  ADD KEY `fk_users_groups_groups` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cart_config`
--
ALTER TABLE `cart_config`
  MODIFY `config_id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cart_data`
--
ALTER TABLE `cart_data`
  MODIFY `cart_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `curr_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `disc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `discount_calculation`
--
ALTER TABLE `discount_calculation`
  MODIFY `disc_calculation_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `discount_columns`
--
ALTER TABLE `discount_columns`
  MODIFY `disc_column_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `discount_groups`
--
ALTER TABLE `discount_groups`
  MODIFY `disc_group_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `discount_group_items`
--
ALTER TABLE `discount_group_items`
  MODIFY `disc_group_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `discount_methods`
--
ALTER TABLE `discount_methods`
  MODIFY `disc_method_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT 'Note: Do not alter the order or id''s of records in table.', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `discount_tax_methods`
--
ALTER TABLE `discount_tax_methods`
  MODIFY `disc_tax_method_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `disc_type_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `location_type`
--
ALTER TABLE `location_type`
  MODIFY `loc_type_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location_zones`
--
ALTER TABLE `location_zones`
  MODIFY `lzone_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `ord_det_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `ord_status_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product_category_attribute_descriptions`
--
ALTER TABLE `product_category_attribute_descriptions`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_option_defaults`
--
ALTER TABLE `product_option_defaults`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_option_groups`
--
ALTER TABLE `product_option_groups`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `product_option_images`
--
ALTER TABLE `product_option_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `reward_points_converted`
--
ALTER TABLE `reward_points_converted`
  MODIFY `rew_convert_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shipping_item_rules`
--
ALTER TABLE `shipping_item_rules`
  MODIFY `ship_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `shipping_options`
--
ALTER TABLE `shipping_options`
  MODIFY `ship_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `ship_rate_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tax_item_rates`
--
ALTER TABLE `tax_item_rates`
  MODIFY `tax_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
