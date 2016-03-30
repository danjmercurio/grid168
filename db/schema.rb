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
# It's strongly recommended that you check this file into your version control system.

ActiveRecord::Schema.define(version: 20160330070949) do

  create_table "admins", force: :cascade do |t|
    t.string   "email",              limit: 255
    t.string   "encrypted_password", limit: 255
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "cities", force: :cascade do |t|
    t.string   "city_name",  limit: 255
    t.integer  "state_id",   limit: 4
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "dmas", force: :cascade do |t|
    t.string   "name",       limit: 255
    t.integer  "city_id",    limit: 4
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "notes", force: :cascade do |t|
    t.text     "content",    limit: 65535
    t.integer  "offer_id",   limit: 4
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "offers", force: :cascade do |t|
    t.integer "outlet_id", limit: 4
    t.float "yearly_offer", limit: 24, default: 0.0, null: false
    t.float "monthly_offer", limit: 24, default: 0.0, null: false
    t.float "weekly_offer", limit: 24, default: 0.0, null: false
    t.float "hourly_rate", limit: 24, default: 0.0, null: false
    t.float "total_hours", limit: 24, default: 0.0, null: false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.float "dollar_amount", limit: 24, default: 0.0, null: false
    t.integer "user_id", limit: 4
    t.string "available_date", limit: 255
    t.text "time_cells", limit: 65535
  end

  create_table "offers_programmers", id: false, force: :cascade do |t|
    t.integer "programmer_id", limit: 4
    t.integer "offer_id",      limit: 4
  end

  add_index "offers_programmers", ["offer_id", "programmer_id"], name: "index_offers_programmers_on_offer_id_and_programmer_id", unique: true, using: :btree

  create_table "offervalues", force: :cascade do |t|
    t.string   "time",       limit: 255
    t.float    "monday",     limit: 24
    t.float    "tuesday",    limit: 24
    t.float    "wednesday",  limit: 24
    t.float    "thursday",   limit: 24
    t.float    "friday",     limit: 24
    t.float    "saturday",   limit: 24
    t.float    "sunday",     limit: 24
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "outlet_types", force: :cascade do |t|
    t.string   "name",       limit: 255
    t.datetime "created_at",             null: false
    t.datetime "updated_at",             null: false
  end

  create_table "outlets", force: :cascade do |t|
    t.string   "name",           limit: 255, null: false
    t.string   "description",    limit: 255
    t.integer  "subs",           limit: 4,   null: false
    t.integer  "dma_id",         limit: 4,   null: false
    t.integer  "user_id",        limit: 4,   null: false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "first_name",     limit: 255
    t.string   "last_name",      limit: 255
    t.string   "phone_number",   limit: 255
    t.string   "time_zone",      limit: 255
    t.integer  "outlet_type_id", limit: 4
    t.string   "programming",    limit: 255
    t.integer  "over_air",       limit: 4
    t.integer  "total_homes",    limit: 4
  end

  add_index "outlets", ["name"], name: "index_outlets_on_name", unique: true, using: :btree

  create_table "programmer_types", force: :cascade do |t|
    t.string   "name",       limit: 255
    t.datetime "created_at",             null: false
    t.datetime "updated_at",             null: false
  end

  create_table "programmers", force: :cascade do |t|
    t.string   "name",               limit: 255
    t.text     "description",        limit: 65535
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "user_id",            limit: 4
    t.string   "first_name",         limit: 255
    t.string   "last_name",          limit: 255
    t.string   "email",              limit: 255
    t.string   "phone",              limit: 255
    t.integer  "programmer_type_id", limit: 4
  end

  create_table "programmers_sub_channel_offers", id: false, force: :cascade do |t|
    t.integer "programmer_id",        limit: 4
    t.integer "sub_channel_offer_id", limit: 4
  end

  add_index "programmers_sub_channel_offers", ["programmer_id", "sub_channel_offer_id"], name: "index_programmers_sub_channel_offers", unique: true, using: :btree

  create_table "states", force: :cascade do |t|
    t.string   "name",       limit: 255
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "sub_channel_offers", force: :cascade do |t|
    t.float    "yearly_offer",      limit: 24,    default: 0.0, null: false
    t.float    "monthly_offer",     limit: 24,    default: 0.0, null: false
    t.float    "weekly_offer",      limit: 24,    default: 0.0, null: false
    t.float    "hourly_rate",       limit: 24,    default: 0.0, null: false
    t.float    "total_hours",       limit: 24,    default: 0.0, null: false
    t.float    "dollar_amount",     limit: 24,    default: 0.0, null: false
    t.text     "half_hour_clicked", limit: 65535
    t.integer  "sub_channel_id",    limit: 4
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "user_id",           limit: 4,                   null: false
  end

  create_table "sub_channel_types", force: :cascade do |t|
    t.string   "name",       limit: 255
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "sub_channels", force: :cascade do |t|
    t.integer  "sub_channel_type_id", limit: 4
    t.integer  "subs",                limit: 4
    t.integer  "outlet_id",           limit: 4
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "name",                limit: 255
  end

  create_table "users", force: :cascade do |t|
    t.string   "email",                  limit: 255, default: "",    null: false
    t.string   "encrypted_password",     limit: 255, default: "",    null: false
    t.string   "reset_password_token",   limit: 255
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer  "sign_in_count",          limit: 4,   default: 0
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip",     limit: 255
    t.string   "last_sign_in_ip",        limit: 255
    t.datetime "created_at"
    t.datetime "updated_at"
    t.boolean  "admin",                              default: false
    t.string   "phone",                  limit: 255
    t.string   "title",                  limit: 255
    t.string   "first_name",             limit: 255
    t.string   "last_name",              limit: 255
  end

  add_index "users", ["email"], name: "index_users_on_email", unique: true, using: :btree
  add_index "users", ["reset_password_token"], name: "index_users_on_reset_password_token", unique: true, using: :btree

end
