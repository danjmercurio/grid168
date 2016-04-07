class AddEmailToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :email, :string
  end
end
