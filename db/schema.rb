# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended to check this file into your version control system.

ActiveRecord::Schema.define(:version => 20120509083727) do

  create_table "admins", :force => true do |t|
    t.string   "email"
    t.string   "encrypted_password"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "cities", :force => true do |t|
    t.string   "city_name"
    t.integer  "state_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "dmas", :force => true do |t|
    t.string   "name"
    t.integer  "city_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "notes", :force => true do |t|
    t.text     "content"
    t.integer  "offer_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "offers", :force => true do |t|
    t.integer  "outlet_id"
    t.float    "yearly_offer",      :default => 0.0, :null => false
    t.float    "monthly_offer",     :default => 0.0, :null => false
    t.float    "weekly_offer",      :default => 0.0, :null => false
    t.float    "hourly_rate",       :default => 0.0, :null => false
    t.float    "total_hours",       :default => 0.0, :null => false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.float    "dollar_amount",     :default => 0.0, :null => false
    t.text     "half_hour_clicked"
    t.integer  "user_id"
  end

  create_table "offers_programmers", :id => false, :force => true do |t|
    t.integer "programmer_id"
    t.integer "offer_id"
  end

  add_index "offers_programmers", ["offer_id", "programmer_id"], :name => "index_offers_programmers_on_offer_id_and_programmer_id", :unique => true

  create_table "offervalues", :force => true do |t|
    t.string   "time"
    t.float    "monday"
    t.float    "tuesday"
    t.float    "wednesday"
    t.float    "thursday"
    t.float    "friday"
    t.float    "saturday"
    t.float    "sunday"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "outlets", :force => true do |t|
    t.string   "name",                        :null => false
    t.string   "description"
    t.integer  "subs",                        :null => false
    t.integer  "dma_id",                      :null => false
    t.integer  "user_id",                     :null => false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "outlet_type",  :default => 0, :null => false
    t.string   "first_name"
    t.string   "last_name"
    t.string   "phone_number"
  end

  add_index "outlets", ["name"], :name => "index_outlets_on_name", :unique => true

  create_table "programmers", :force => true do |t|
    t.string   "name"
    t.text     "description"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "user_id"
    t.string   "first_name"
    t.string   "last_name"
    t.string   "email"
    t.string   "phone"
  end

  create_table "programmers_sub_channel_offers", :id => false, :force => true do |t|
    t.integer "programmer_id"
    t.integer "sub_channel_offer_id"
  end

  add_index "programmers_sub_channel_offers", ["programmer_id", "sub_channel_offer_id"], :name => "index_programmers_sub_channel_offers", :unique => true

  create_table "states", :force => true do |t|
    t.string   "name"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "sub_channel_offers", :force => true do |t|
    t.float    "yearly_offer",      :default => 0.0, :null => false
    t.float    "monthly_offer",     :default => 0.0, :null => false
    t.float    "weekly_offer",      :default => 0.0, :null => false
    t.float    "hourly_rate",       :default => 0.0, :null => false
    t.float    "total_hours",       :default => 0.0, :null => false
    t.float    "dollar_amount",     :default => 0.0, :null => false
    t.text     "half_hour_clicked"
    t.integer  "sub_channel_id"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "user_id",                            :null => false
  end

  create_table "sub_channel_types", :force => true do |t|
    t.string   "name"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "sub_channels", :force => true do |t|
    t.integer  "sub_channel_type_id"
    t.integer  "subs"
    t.integer  "outlet_id"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "name"
  end

  create_table "users", :force => true do |t|
    t.string   "email",                  :default => "",    :null => false
    t.string   "encrypted_password",     :default => "",    :null => false
    t.string   "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer  "sign_in_count",          :default => 0
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip"
    t.string   "last_sign_in_ip"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.boolean  "admin",                  :default => false
    t.string   "phone"
    t.string   "title"
    t.string   "first_name"
    t.string   "last_name"
  end

  add_index "users", ["email"], :name => "index_users_on_email", :unique => true
  add_index "users", ["reset_password_token"], :name => "index_users_on_reset_password_token", :unique => true

end
