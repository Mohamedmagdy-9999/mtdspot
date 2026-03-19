<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalAfterCouponToUserPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('user_purchases', function (Blueprint $table) {
            $table->text('total_after_coupon')->after('total');
            $table->string('service')->after('total_after_coupon');
            $table->string('status')->after('service');
            $table->Integer('coupon_id')->after('status');
            $table->Integer('user_address_id')->after('coupon_id');
        });
    }

    public function down()
    {
        Schema::table('user_purchases', function (Blueprint $table) {
            
            $table->dropColumn(['coupon_id', 'user_address_id', 'status', 'total_after_coupon','service']);
        });
    }
}
