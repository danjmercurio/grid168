class AddAndRemovePhoneNumber < ActiveRecord::Migration
  def up
  	add_column :outlets, :phone_number, :string
  end

  def down
  	remove_column :outlets, :phone_number
  end
end
