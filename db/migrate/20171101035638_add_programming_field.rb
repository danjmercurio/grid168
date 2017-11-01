class AddProgrammingField < ActiveRecord::Migration
  def change
  	add_column :offers, :programming, :string
  end
end
