class AddUserIdToProgrammers < ActiveRecord::Migration
  def change
    add_column :programmers, :user_id, :integer
  end
end
