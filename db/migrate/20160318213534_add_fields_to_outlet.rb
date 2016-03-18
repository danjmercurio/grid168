class AddFieldsToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :programming, :string
    add_column :outlets, :over_air, :integer
    add_column :outlets, :total_homes, :integer
  end
end
