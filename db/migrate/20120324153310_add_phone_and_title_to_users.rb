class AddPhoneAndTitleToUsers < ActiveRecord::Migration
  def change
    add_column :users, :phone, :string
    add_column :users, :title, :string
  end
end
