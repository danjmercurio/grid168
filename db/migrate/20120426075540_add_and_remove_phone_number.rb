class AddAndRemovePhoneNumber < ActiveRecord::Migration
  def up
  	add_column :outlets, :phone_number, :string
  	remove_column :sub_channels, :phone_number
  end

  def down
  	remove_column :outlets, :phone_number
  	add_column :sub_channels, :phone_number, :string
  end
end
