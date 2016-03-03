class AddFirstNameAndLastNameToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :first_name, :string
    add_column :outlets, :last_name, :string
    add_column :sub_channels, :name, :string
    add_column :sub_channels, :phone_number, :string
  end
end
