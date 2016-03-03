class UniqueOutlet < ActiveRecord::Migration
  def change
  	add_index "outlets", ["name"], :unique => true
  end

end
